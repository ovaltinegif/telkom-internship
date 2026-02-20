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
        // Ambil user student yang BELUM punya magang (opsional logic-nya, disini kita ambil semua student dulu)
        $students = User::where('role', 'student')->get();

        // Ambil semua mentor
        $mentors = User::where('role', 'mentor')->get();

        // Ambil semua divisi
        $divisions = Division::all();

        return view('admin.internships.create', compact('students', 'mentors', 'divisions'));
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
        if ($mentor->activeInternsCount() >= $quota) {
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

        $users = User::with('studentProfile')
            ->when($role, function ($query, $role) {
            return $query->where('role', $role);
        })
            ->whereDoesntHave('internship', function ($query) {
            $query->where('status', 'rejected');
        })
            ->latest()
            ->paginate(10); // Pagination

        return view('admin.users.index', compact('users', 'role'));
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
    /**
     * Monitoring Magang: List semua magang aktif.
     */
    public function internships(Request $request)
    {
        $status = $request->query('status', 'pending'); // Default to 'pending' (Applicants)

        // Counts for Tabs
        $pendingCount = Internship::where('status', 'pending')->count();
        $onboardingCount = Internship::where('status', 'onboarding')->count();
        $activeCount = Internship::where('status', 'active')->count();

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
                ->with(['student.studentProfile', 'mentor', 'division', 'extensions' => function ($q) {
                $q->where('status', 'pending');
            }])
                ->latest()
                ->paginate(10)
                ->appends(['status' => $status]);
        }
        else {
            $internships = Internship::with(['student.studentProfile', 'mentor', 'division'])
                ->where('status', $status)
                ->latest()
                ->paginate(10)
                ->appends(['status' => $status]);
        }

        // Pass Divisions and Mentors for Dropdowns in Review Modal
        $divisions = Division::all();
        $mentors = User::where('role', 'mentor')->get();

        return view('admin.internships.index', compact('internships', 'status', 'pendingCount', 'onboardingCount', 'activeCount', 'extensionCount', 'divisions', 'mentors'));
    }

    /**
     * Approve Internship (Pending -> Onboarding)
     */
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
        if ($mentor->activeInternsCount() >= $quota) {
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

        // Optional: Send Notification to Student

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

        // Send Rejection Email (Synchronous)
        if ($internship->student && $internship->student->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->send(new \App\Mail\InternshipRejected($internship));
            }
            catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email penolakan magang: ' . $e->getMessage());
            }
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

        // Note: You can uncomment this if you want to strictly enforce it. 
        // For now, allow admin to override or maybe just warn? 
        // Based on user request "jika aktor mahasiswa... sudah isi pakta integritas ... lalu admin approve", it implies admin makes the call.
        // But the system should probably check.
        if (!$hasSignedPact) {
            return back()->with('error', 'Mahasiswa belum mengupload Pakta Integritas yang sudah ditandatangani.');
        }

        $internship->update([
            'status' => 'active',
            // 'mentor_id' => $request->mentor_id, // Already set during approval
            // 'division_id' => $request->division_id, // Already set during approval
        ]);

        $message = 'Program magang berhasil diaktifkan. Mahasiswa kini berstatus Aktif dengan Mentor & Divisi terpilih.';

        // Trigger Email Notification (Account Active, Silakan Ambil ID Card)
        if ($internship->student && $internship->student->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->send(new \App\Mail\InternshipActive($internship));
                $message .= ' Email notifikasi telah dikirim.';
            }
            catch (\Exception $e) {
                // Log error but don't stop the process
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email aktivasi magang: ' . $e->getMessage());
                $message .= ' Namun, email notifikasi gagal dikirim (Cek Log).';
            }
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
        // ...
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

        return redirect()->back()->with('success', 'Dokumen kelulusan berhasil dikirim!');
    }




    /**
     * Form Edit Monitoring Magang
     */
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