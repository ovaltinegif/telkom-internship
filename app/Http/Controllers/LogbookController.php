<?php

namespace App\Http\Controllers;

use App\Models\DailyLogbook;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Attendance;

class LogbookController extends Controller
{
    /**
     * Menampilkan daftar semua logbook (Activity).
     */
    public function index()
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard');
        }

        $logbooks = DailyLogbook::where('internship_id', $internship->id)
            ->latest()
            ->paginate(10); // Pagination for activity page

        // Fetch Permission History
        $permissions = Attendance::where('internship_id', $internship->id)
            ->where('status', 'permit')
            ->latest()
            ->get();

        // Fetch Attendance History (Present)
        $attendances = Attendance::where('internship_id', $internship->id)
            ->where('status', 'present')
            ->latest()
            ->get();

        return view('logbooks.index', compact('logbooks', 'permissions', 'attendances'));
    }

    /**
     * Menampilkan form isi logbook.
     */
    public function create()
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        // Cek apakah mahasiswa punya magang
        if (!$internship) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar dalam program magang.');
        }

        // Cek status aktif
        if ($internship->status !== 'active') {
            return redirect()->route('dashboard')->with('error', 'Akun magang Anda belum aktif atau masih dalam proses verifikasi.');
        }

        // Cek apakah sudah isi logbook HARI INI
        $todayLogbook = DailyLogbook::where('internship_id', $internship->id)
            ->whereDate('date', now())
            ->exists();

        if ($todayLogbook) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah mengisi logbook hari ini. Logbook hanya dapat diisi satu kali per hari.');
        }

        return view('logbooks.create');
    }

    /**
     * Menyimpan data logbook ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'date' => 'required|date',
            'activity' => 'required|string',
            'evidence' => 'nullable|file|mimes:jpg,png,pdf,jpeg|max:5120', // Maksimal 5MB
        ]);

        // 2. Cari Data Internship milik User yang sedang login
        // Asumsinya 1 user mahasiswa punya 1 data internship
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->withErrors(['msg' => 'Data magang tidak ditemukan. Hubungi admin.']);
        }

        // 3. Handle Upload File Bukti (Jika ada)
        // Check duplicate date
        $exists = DailyLogbook::where('internship_id', $internship->id)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengisi logbook untuk tanggal tersebut.');
        }

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            // Simpan ke folder: storage/app/public/evidence
            $evidencePath = $request->file('evidence')->store('evidence', 'public');
        }

        // 4. Simpan ke Database
        DailyLogbook::create([
            'internship_id' => $internship->id,
            'date' => $request->date,
            'activity' => $request->activity,
            'evidence' => $evidencePath,
            'status' => 'pending', // Default status menunggu persetujuan mentor
        ]);

        // 5. Redirect kembali dengan pesan sukses
        // 5. Redirect kembali dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Logbook berhasil disimpan!');
    }

    /**
     * Handle Image Upload from Trix Editor.
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('logbook-images', 'public');
            return response()->json([
                'url' => Storage::url($path),
            ]);
        }
    }
}