<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\DailyLogbook;
use Illuminate\Support\Facades\Auth;    

class MentorController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang dibimbing oleh mentor yang sedang login.
     */
    public function myStudents()
    {
        $internships = Internship::with(['student.studentProfile', 'division'])
                        ->where('mentor_id', Auth::id())
                        ->get();

        return view('mentor.students.index', compact('internships'));
    }

    /**
     * Menampilkan daftar logbook yang perlu disetujui (Status: pending)
     */
    public function approvals()
    {
        $pendingLogbooks = DailyLogbook::with(['internship.student'])
            ->whereHas('internship', function($q) {
                $q->where('mentor_id', Auth::id());
            })
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('mentor.approvals.index', compact('pendingLogbooks'));
    }

    public function showStudent($id)
    {
        // Cari data magang berdasarkan ID, pastikan mentornya benar (security check)
        $internship = Internship::with([
                            'student.studentProfile', 
                            'dailyLogbooks' => function($query) {
                                $query->latest(); // Urutkan logbook dari yang terbaru
                            },
                            'attendances' => function($query) {
                                $query->latest(); // Urutkan absen dari yang terbaru
                            }
                        ])
                        ->where('mentor_id', Auth::id())
                        ->findOrFail($id);

        return view('mentor.students.show', compact('internship'));
    }

    /**
     * Menyimpan status Approval/Reject logbook.
     */
    public function updateLogbook(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'mentor_note' => 'nullable|string|max:255',
        ]);

        $logbook = DailyLogbook::findOrFail($id);

        // Security: Pastikan logbook ini milik mahasiswa yang dibimbing mentor ini
        if ($logbook->internship->mentor_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menilai logbook ini.');
        }

        $logbook->update([
            'status' => $request->status,
            'mentor_note' => $request->mentor_note,
        ]);

        return back()->with('success', 'Status logbook berhasil diperbarui.');
    }
}
