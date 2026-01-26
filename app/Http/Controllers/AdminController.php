<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard Admin: Melihat ringkasan data.
     */
    public function dashboard()
    {
        // Hitung statistik sederhana
        $totalStudents = User::where('role', 'student')->count();
        $totalMentors  = User::where('role', 'mentor')->count();
        $activeInternships = Internship::where('status', 'active')->count();

        // Ambil 5 data magang terbaru untuk ditampilkan di tabel
        $recentInternships = Internship::with(['student', 'mentor', 'division'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('totalStudents', 'totalMentors', 'activeInternships', 'recentInternships'));
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
            'student_id'  => 'required|exists:users,id',
            'mentor_id'   => 'required|exists:users,id',
            'division_id' => 'required|exists:divisions,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ]);

        // Cek apakah mahasiswa ini sudah punya magang aktif? (Validasi tambahan)
        $exists = Internship::where('student_id', $request->student_id)
                    ->whereIn('status', ['active', 'onboarding'])
                    ->exists();

        if ($exists) {
            return back()->with('error', 'Mahasiswa ini sudah memiliki program magang aktif!');
        }

        // Simpan
        Internship::create([
            'student_id'  => $request->student_id,
            'mentor_id'   => $request->mentor_id,
            'division_id' => $request->division_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => 'active', // Langsung aktif
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Mahasiswa berhasil didaftarkan magang!');
    }
    /**
     * Data User: List semua user.
     */
    public function users(Request $request)
    {
        $role = $request->query('role');
        
        $users = User::when($role, function ($query, $role) {
                    return $query->where('role', $role);
                })
                ->latest()
                ->paginate(10); // Pagination

        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Kelola Divisi: List semua divisi.
     */
    public function divisions()
    {
        $divisions = Division::all();
        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Form Tambah Divisi
     */
    public function createDivision()
    {
        return view('admin.divisions.create');
    }

    /**
     * Simpan Divisi Baru
     */
    public function storeDivision(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Division::create($request->all());

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    /**
     * Form Edit Divisi
     */
    public function editDivision($id)
    {
        $division = Division::findOrFail($id);
        return view('admin.divisions.edit', compact('division'));
    }

    /**
     * Update Divisi
     */
    public function updateDivision(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $division = Division::findOrFail($id);
        $division->update($request->all());

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil diperbarui!');
    }

    /**
     * Hapus Divisi
     */
    public function destroyDivision($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus!');
    }

    /**
     * Monitoring Magang: List semua magang aktif.
     */
    public function internships()
    {
        $internships = Internship::with(['student', 'mentor', 'division'])
                        ->latest()
                        ->paginate(10);

        return view('admin.internships.index', compact('internships'));
    }

    /**
     * Form Edit Monitoring Magang
     */
    public function editInternship($id)
    {
        $internship = Internship::with(['student', 'division'])->findOrFail($id);
        return view('admin.internships.edit', compact('internship'));
    }

    /**
     * Update Data Monitoring Magang
     */
    public function updateInternship(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,finished,onboarding',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $internship = Internship::findOrFail($id);
        $internship->update($request->all());

        return redirect()->route('admin.internships.index')->with('success', 'Data magang berhasil diperbarui!');
    }
}