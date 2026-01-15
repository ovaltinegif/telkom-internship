<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Internship;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function create()
    {
        // Cek data magang, send ke dashboard 
        if (Internship::where('student_id', Auth::id())->exists()) {
            return redirect()->route('dashboard');
        }

        $divisions = Division::all();
        return view('internships.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Internship::create([
            'student_id' => Auth::id(),
            'division_id' => $request->division_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active', // Set status awal menjadi 'active'  
        ]);

        return redirect()->route('dashboard')->with('success', 'Selamat! Data magang berhasil dibuat.');
    }
}