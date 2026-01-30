<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    // Menampilkan Form Penilaian
    public function create(Internship $internship)
    {
        // Security Check: Pastikan yang menilai adalah mentor yang benar
        if (auth()->user()->id !== $internship->mentor_id) {
             abort(403, 'Anda bukan mentor untuk magang ini.');
        }

        return view('mentor.evaluations.create', compact('internship'));
    }

    // Menyimpan Data Nilai ke Database
    public function store(Request $request, Internship $internship)
    {
        // dd('store hit'); // DEBUG
        // Validasi input
        $validated = $request->validate([
            'discipline_score' => 'required|integer|min:0|max:100',
            'technical_score'  => 'required|integer|min:0|max:100',
            'soft_skill_score' => 'required|integer|min:0|max:100',
            'feedback'         => 'nullable|string',
        ]);

        // Hitung nilai akhir (rata-rata) otomatis
        $finalScore = ($request->discipline_score + $request->technical_score + $request->soft_skill_score) / 3;

        // Simpan ke database
        Evaluation::create([
            'internship_id'    => $internship->id,
            'discipline_score' => $request->discipline_score,
            'technical_score'  => $request->technical_score,
            'soft_skill_score' => $request->soft_skill_score,
            'final_score'      => round($finalScore), // Saya tambah round() biar angkanya bulat
            'feedback'         => $request->feedback,
        ]);

        // PERBAIKAN DISINI: Redirect ke detail mahasiswa, bukan dashboard umum
        return redirect()->route('mentor.students.show', $internship->student_id)
            ->with('success', 'Nilai berhasil disimpan!');
    }
}