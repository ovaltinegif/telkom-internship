<?php

namespace App\Http\Controllers;

use App\Models\DailyLogbook;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LogbookController extends Controller
{
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
        return redirect()->route('dashboard')->with('success', 'Logbook berhasil disimpan!');
    }
}