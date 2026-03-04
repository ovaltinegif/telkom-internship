<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Admin: Melihat ringkasan data.
     */
    public function dashboard()
    {
        // Hitung statistik sederhana
        $totalStudents = User::where('role', 'student')->count();
        $totalMentors = User::where('role', 'mentor')->count();
        $activeInternships = Internship::where('status', 'active')->count();

        // Ambil 5 data magang terbaru untuk ditampilkan di tabel
        $recentInternships = Internship::with(['student.studentProfile', 'mentor', 'division'])
            ->latest()
            ->take(5)
            ->get();

        // Ambil data perpanjangan magang yang pending
        $pendingExtensions = \App\Models\InternshipExtension::with(['internship.student', 'internship.division', 'internship.mentor'])
            ->where('status', 'pending')
            ->get();

        // Hitung growth (data baru bulan ini)
        $studentGrowth = User::where('role', 'student')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $mentorGrowth = User::where('role', 'mentor')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $internshipGrowth = Internship::where('status', 'active')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Count pending applicants (new)
        $pendingApplicants = Internship::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalStudents', 'totalMentors', 'activeInternships',
            'recentInternships', 'pendingExtensions',
            'studentGrowth', 'mentorGrowth', 'internshipGrowth',
            'pendingApplicants'
        ));
    }

    /**
     * Form Setup Magang: Admin memilih Student, Mentor, dan Divisi.
     */
    public function createInternship()
    {
        // Ambil semua divisi (divisi jumlahnya sedikit, aman di-load semua)
        $divisions = Division::all();

        return view('admin.internships.create', compact('divisions'));
    }

    /**
     * AJAX Search untuk Student (Max 20 results)
     */
    public function searchStudents(Request $request)
    {
        $search = $request->query('q');

        $students = User::where('role', 'student')
            ->whereDoesntHave('internship', function ($q) {
            // Jangan tampilkan mahasiswa yang sudah magang aktif/onboarding
            $q->whereIn('status', ['active', 'onboarding']);
        })
            ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                }
                );
            })
            ->select('id', 'name', 'email')
            ->take(20)
            ->get();

        return response()->json($students);
    }

    /**
     * AJAX Search untuk Mentor (Max 20 results, beserta kuota)
     */
    public function searchMentors(Request $request)
    {
        $search = $request->query('q');

        $mentors = User::where('role', 'mentor')
            ->with(['mentorProfile', 'activeInternships'])
            ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                }
                );
            })
            ->take(20)
            ->get();

        $formattedMentors = $mentors->map(function ($mentor) {
            $quota = $mentor->mentorProfile->quota ?? 5;
            $active = $mentor->activeInternships->count();
            $isFull = $active >= $quota;

            return [
            'id' => $mentor->id,
            'name' => $mentor->name,
            'email' => $mentor->email,
            'quota' => $quota,
            'active' => $active,
            'is_full' => $isFull,
            'display_text' => "{$mentor->name} ({$active}/{$quota})" . ($isFull ? ' - Penuh' : '')
            ];
        });

        return response()->json($formattedMentors);
    }

    /**
     * Simpan Data Magang ke Database.
     */
    public function storeInternship(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'division_id' => 'required|exists:divisions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Cek apakah mahasiswa ini sudah punya magang aktif? (Validasi tambahan)
        $exists = Internship::where('student_id', $request->student_id)
            ->whereIn('status', ['active', 'onboarding'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Mahasiswa ini sudah memiliki program magang aktif!');
        }

        // Cek Kuota Mentor
        $mentor = User::findOrFail($request->mentor_id);
        $quota = $mentor->mentorProfile->quota ?? 5; // Default 5 jika null
        if ($mentor->activeInternships()->count() >= $quota) {
            return back()->with('error', 'Mentor ini sudah mencapai batas kuota (' . $quota . ' mahasiswa). Silakan pilih mentor lain.');
        }

        // Simpan
        Internship::create([
            'student_id' => $request->student_id,
            'mentor_id' => $request->mentor_id,
            'division_id' => $request->division_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active', // Langsung aktif
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Mahasiswa berhasil didaftarkan magang!');
    }
    /**
     * Data User: List semua user.
     */
    public function users(Request $request)
    {
        $role = $request->query('role');
        $studentType = $request->query('student_type'); // New filter parameter

        $users = User::with(['studentProfile', 'mentoredInternships' => function ($query) {
            // Only load active or onboarding internships for display
            $query->whereIn('status', ['active', 'onboarding'])->with('student');
        }])
            ->when($role, function ($query, $role) {
            return $query->where('role', $role);
        })
            // Apply student type filter if role is student and filter is set
            ->when($role === 'student' && $studentType, function ($query) use ($studentType) {
            return $query->whereHas('studentProfile', function ($q) use ($studentType) {
                    if ($studentType === 'smk') {
                        $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                    }
                    elseif ($studentType === 'mahasiswa') {
                        $q->where('student_type', 'mahasiswa')->where('education_level', '!=', 'SMK');
                    }
                }
                );
            })
            ->where('role', '!=', 'admin') // Exclude admins from the management database
            ->whereDoesntHave('internship', function ($query) {
            $query->where('status', 'rejected');
        })
            ->latest()
            ->paginate(10); // Pagination

        return view('admin.users.index', compact('users', 'role', 'studentType'));
    }

    /**
     * Form Tambah Mentor Baru
     */
    public function createMentor()
    {
        $divisions = Division::all();
        return view('admin.mentors.create', compact('divisions'));
    }

    /**
     * Simpan Data Mentor Baru
     */
    public function storeMentor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nik' => 'required|string|unique:mentor_profiles',
            'position' => 'required|string|max:255',
        ]);

        // 1. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mentor',
        ]);

        // 2. Create Mentor Profile
        \App\Models\MentorProfile::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.users.index', ['role' => 'mentor'])
            ->with('success', 'Mentor baru berhasil ditambahkan!');
    }

    /**
     * Monitoring Magang: List semua magang aktif.
     */
    public function internships(Request $request)
    {
        $status = $request->query('status', 'pending'); // Default to 'pending' (Applicants)
        $studentType = $request->query('student_type');

        // Counts for Tabs
        $pendingCount = Internship::where('status', 'pending')->count();
        $onboardingCount = Internship::where('status', 'onboarding')->count();
        $activeCount = Internship::where('status', 'active')->count();
        $finishedCount = Internship::where('status', 'finished')->count();

        // Count Pending Extensions
        $extensionCount = \App\Models\InternshipExtension::where('status', 'pending')->count();

        // Redirect if trying to view extensions but none exist
        if ($status === 'extension' && $extensionCount === 0) {
            return redirect()->route('admin.internships.index', ['status' => 'pending']);
        }

        // Filter Logic
        if ($status === 'extension') {
            $internships = Internship::whereHas('extensions', function ($q) {
                $q->where('status', 'pending');
            })
                ->when($studentType, function ($query) use ($studentType) {
                return $query->whereHas('student.studentProfile', function ($q) use ($studentType) {
                        if ($studentType === 'smk') {
                            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                        }
                        elseif ($studentType === 'mahasiswa') {
                            $q->where('student_type', 'mahasiswa')->where('education_level', '!=', 'SMK');
                        }
                    }
                    );
                })
                ->with(['student.studentProfile', 'mentor', 'division', 'extensions' => function ($q) {
                $q->where('status', 'pending');
            }])
                ->latest()
                ->paginate(10)
                ->appends(['status' => $status, 'student_type' => $studentType]);
        }
        else {
            $internships = Internship::with(['student.studentProfile', 'mentor', 'division'])
                ->where('status', $status)
                ->when($studentType, function ($query) use ($studentType) {
                return $query->whereHas('student.studentProfile', function ($q) use ($studentType) {
                        if ($studentType === 'smk') {
                            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                        }
                        elseif ($studentType === 'mahasiswa') {
                            $q->where('student_type', 'mahasiswa')->where('education_level', '!=', 'SMK');
                        }
                    }
                    );
                })
                ->latest()
                ->paginate(10)
                ->appends(['status' => $status, 'student_type' => $studentType]);
        }

        // Pass Divisions and Mentors for Dropdowns in Review Modal
        $divisions = Division::all();
        $mentors = User::where('role', 'mentor')->get();

        return view('admin.internships.index', compact('internships', 'status', 'studentType', 'pendingCount', 'onboardingCount', 'activeCount', 'finishedCount', 'extensionCount', 'divisions', 'mentors'));
    }

    /**
     * Approve Internship (Pending -> Onboarding)
     * Admin uploads Surprise Jawaban & Pakta Integrity Template
     */
    public function approveInternship(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status magang tidak valid untuk disetujui.');
        }

        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'mentor_id' => 'required|exists:users,id',
        ]);

        // Cek Kuota Mentor
        $mentor = User::findOrFail($request->mentor_id);
        $quota = $mentor->mentorProfile->quota ?? 5; // Default 5
        if ($mentor->activeInternships()->count() >= $quota) {
            return back()->with('error', 'Mentor ini sudah mencapai batas kuota (' . $quota . ' mahasiswa). Mohon pilih mentor lain.');
        }

        // Hardcoded Link (per user request)
        $paktaLink = 'https://docs.google.com/document/d/1MYswMj78AfqPH9yBIeH8U9VBA5jDaRguTzwQX-9ARe8/edit?tab=t.0';

        // Store Google Docs Link
        $internship->documents()->create([
            'name' => 'Link Template Pakta Integritas',
            'type' => 'pakta_integritas',
            'file_path' => $paktaLink, // Storing URL directly
            'is_verified' => true
        ]);

        $internship->update([
            'status' => 'onboarding',
            'division_id' => $request->division_id,
            'mentor_id' => $request->mentor_id,
        ]);

        try {
            // Optional: Send Notification to Student (Queued)
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipApproved($internship));
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipApproved email: ' . $e->getMessage());
        }

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', 'Pengajuan diterima! Mahasiswa kini statusnya Onboarding.');
    }

    /**
     * Reject Internship (Pending -> Rejected)
     */
    public function rejectInternship(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status magang tidak valid untuk ditolak.');
        }

        // Update status to rejected
        $internship->update(['status' => 'rejected']);

        try {
            // Send Rejection Email (Queued)
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipRejected($internship));
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipRejected email: ' . $e->getMessage());
        }

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', 'Pengajuan magang ditolak. Data akan dihapus otomatis dalam 3 hari.');
    }

    /**
     * Activate Internship (Onboarding -> Active)
     */
    public function activateInternship(Request $request, $id)
    {
        $internship = Internship::with('documents')->findOrFail($id);

        if ($internship->status !== 'onboarding') {
            return back()->with('error', 'Status magang tidak valid untuk diaktivasi.');
        }

        // Check if student has uploaded signed pakta integritas
        $hasSignedPact = $internship->documents()->where('type', 'pakta_integritas_signed')->exists();

        if (!$hasSignedPact) {
            return back()->with('error', 'Mahasiswa belum mengupload Pakta Integritas yang sudah ditandatangani.');
        }

        $request->validate([
            'induction_date' => 'required|date',
            'induction_time' => 'required',
        ]);

        $internship->update([
            'status' => 'active',
        ]);

        $inductionData = [
            'date' => $request->induction_date,
            'time' => $request->induction_time,
            'location' => 'Ruang Kompeten Unit Shared Service & General Support Witel Semarang Jateng Utara Lantai 2 GMP Pahlawan, Jl. Pahlawan No. 10, Kota Semarang',
            'activity' => 'Induksi Peserta Magang & Pengambilan ID Card',
        ];

        $message = 'Program magang berhasil diaktifkan. Mahasiswa kini berstatus Aktif dengan Mentor & Divisi terpilih.';

        try {
            // Trigger Email Notification (Queued)
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipActive($internship, $inductionData));
                $message .= ' Email notifikasi telah antre dikirim.';
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipActive email: ' . $e->getMessage());
            $message .= ' Namun email gagal dikirim (Cek konfigurasi SMTP Anda).';
        }

        return redirect()->route('admin.internships.index', ['status' => 'onboarding'])
            ->with('success', $message);
    }

    /**
     * Complete Internship (Upload Certificate & Assessment)
     */
    public function completeInternship(Request $request, $id)
    {
        $internship = Internship::with('student.studentProfile')->findOrFail($id);

        if ($internship->status !== 'finished') {
            return back()->with('error', 'Status magang belum selesai sehingga belum bisa diproses kelulusannya.');
        }

        $isSmk = optional($internship->student->studentProfile)->education_level === 'SMK';

        $rules = [
            'sertifikat_kelulusan' => 'required|file|mimes:pdf|max:2048',
        ];

        if ($isSmk) {
            $rules['laporan_penilaian_pkl'] = 'required|file|mimes:pdf|max:2048';
        }
        else {
            $rules['laporan_penilaian_pkl'] = 'nullable|file|mimes:pdf|max:2048';
        }

        $request->validate($rules);

        // Upload Certificate
        if ($request->hasFile('sertifikat_kelulusan')) {
            $path = $request->file('sertifikat_kelulusan')->store('documents/admin', 'public');

            // Delete old if exists (optional cleanup) or just add new
            $internship->documents()->updateOrCreate(
            ['type' => 'sertifikat_kelulusan'],
            [
                'name' => 'Sertifikat Kelulusan Magang',
                'file_path' => $path,
                'is_verified' => true
            ]
            );
        }

        // Upload PKL Assessment (Required for SMK, Optional for others)
        if ($request->hasFile('laporan_penilaian_pkl')) {
            $path = $request->file('laporan_penilaian_pkl')->store('documents/admin', 'public');

            $internship->documents()->updateOrCreate(
            ['type' => 'laporan_penilaian_pkl'],
            [
                'name' => 'Laporan Penilaian PKL',
                'file_path' => $path,
                'is_verified' => true
            ]
            );
        }

        try {
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipFinished($internship));
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipFinished email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Dokumen kelulusan berhasil dikirim!');
    }




    /**
     * Detail Monitoring Magang (Read Only)
     */
    public function showInternship($id)
    {
        $internship = Internship::with(['student', 'division', 'documents', 'mentor'])->findOrFail($id);
        $mentors = User::where('role', 'mentor')->get();
        $divisions = Division::all();
        return view('admin.internships.show', compact('internship', 'mentors', 'divisions'));
    }

    /**
     * Approve Extension Request
     */
    public function approveExtension($id)
    {
        $extension = \App\Models\InternshipExtension::findOrFail($id);

        // Update extension status
        $extension->update([
            'status' => 'approved'
        ]);

        // Update internship end date
        $internship = $extension->internship;
        $internship->update([
            'end_date' => $extension->new_end_date
        ]);

        return back()->with('success', 'Pengajuan perpanjangan berhasil disetujui.');
    }

    /**
     * Reject Extension Request
     */
    public function rejectExtension(Request $request, $id)
    {
        $extension = \App\Models\InternshipExtension::findOrFail($id);

        $extension->update([
            'status' => 'rejected',
            'reason' => $request->reason // Optional reason
        ]);

        return back()->with('success', 'Pengajuan perpanjangan berhasil ditolak.');
    }
}