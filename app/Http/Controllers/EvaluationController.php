<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    // Menampilkan Form Penilaian
    public function create(Internship $internship)
    {
        // Pastikan hanya mentor yang bersangkutan yang bisa menilai
        // (Sesuaikan logika ini dengan sistem role kamu, contoh di bawah jika pakai id)
        if (auth()->user()->id !== $internship->mentor_id) {
             abort(403, 'Anda bukan mentor untuk magang ini.');
        }

        return view('evaluations.create', compact('internship'));
    }

    // Menyimpan Data Nilai ke Database
    public function store(Request $request, Internship $internship)
    {
        // Validasi input
        $validated = $request->validate([
            'discipline_score' => 'required|integer|min:0|max:100',
            'technical_score' => 'required|integer|min:0|max:100',
            'soft_skill_score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        // Hitung nilai akhir (rata-rata) otomatis
        $finalScore = ($request->discipline_score + $request->technical_score + $request->soft_skill_score) / 3;

        // Simpan ke database
        Evaluation::create([
            'internship_id' => $internship->id,
            'discipline_score' => $request->discipline_score,
            'technical_score' => $request->technical_score,
            'soft_skill_score' => $request->soft_skill_score,
            'final_score' => $finalScore,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('dashboard')->with('success', 'Nilai berhasil disimpan!');
    }
}