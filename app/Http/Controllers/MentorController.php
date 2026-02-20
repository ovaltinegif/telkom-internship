<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\DailyLogbook;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class MentorController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang dibimbing oleh mentor yang sedang login.
     */
    public function myStudents(Request $request)
    {
        $status = $request->get('status', 'active');
        $type = $request->get('type', 'all'); // all, mahasiswa, smk

        $query = Internship::with(['student.studentProfile', 'division'])
                        ->where('mentor_id', Auth::id());

        // Calculate counts for main tabs
        $activeCount = (clone $query)->where('status', 'active')->count();
        $finishedCount = (clone $query)->where('status', 'finished')->count();

        // Calculate counts for sub-filters (Active Only)
        $activeMahasiswaCount = (clone $query)->where('status', 'active')->whereHas('student.studentProfile', function($q) {
            $q->where('education_level', '!=', 'SMK');
        })->count();
        
        $activeSmkCount = (clone $query)->where('status', 'active')->whereHas('student.studentProfile', function($q) {
            $q->where('education_level', 'SMK');
        })->count();

        // Filter based on status
        $query->where('status', $status);

        // Filter based on type (only if status is active)
        if ($status === 'active' && $type !== 'all') {
            if ($type === 'smk') {
                $query->whereHas('student.studentProfile', function($q) {
                    $q->where('education_level', 'SMK');
                });
            } elseif ($type === 'mahasiswa') {
                $query->whereHas('student.studentProfile', function($q) {
                    $q->where('education_level', '!=', 'SMK');
                });
            }
        }

        $internships = $query->get();

        return view('mentor.students.index', compact(
            'internships', 'status', 'type', 
            'activeCount', 'finishedCount',
            'activeMahasiswaCount', 'activeSmkCount'
        ));
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

    /**
     * Menampilkan Transkrip Nilai Mahasiswa untuk Mentor.
     */
    public function transcript($id)
    {
        $internship = Internship::with(['evaluation', 'student.studentProfile', 'division'])
            ->where('mentor_id', Auth::id())
            ->findOrFail($id);

        if (!$internship->evaluation) {
            abort(404, 'Belum ada evaluasi nilai untuk mahasiswa ini.');
        }

        return view('documents.transcript', compact('internship'));
    }

    /**
     * Generate Laporan Bulanan (View/PDF) untuk Mentor.
     */
    public function monthlyReport(Request $request, $id)
    {
        $internship = Internship::where('mentor_id', Auth::id())
            ->findOrFail($id);

        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        // Get attendances
        $attendances = Attendance::where('internship_id', $internship->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        // Get logbooks
        $logbooks = DailyLogbook::where('internship_id', $internship->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        return view('reports.monthly', compact('internship', 'attendances', 'logbooks', 'month', 'year'));
    }
}
