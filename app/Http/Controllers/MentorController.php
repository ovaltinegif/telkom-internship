<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;
use Illuminate\Support\Facades\Auth;    

class MentorController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang dibimbing oleh mentor yang sedang login.
     */
    public function myStudents()
    {
        // Ambil data internship dimana mentor_id = ID user yang sedang login
        // Kita gunakan 'with' untuk eager loading (mengambil data student & division sekaligus biar cepat)
        $internships = Internship::with(['student', 'division'])
                        ->where('mentor_id', Auth::id())
                        ->get();

        return view('mentor.students.index', compact('internships'));
    }
}
