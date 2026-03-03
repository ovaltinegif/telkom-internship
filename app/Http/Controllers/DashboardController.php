<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\DailyLogbook;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Cek jika User adalah ADMIN -> Lempar ke Dashboard Admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 2. Cek jika User adalah MENTOR -> Lempar ke Dashboard Mentor
        if ($user->role === 'mentor') {
            return redirect()->route('mentor.dashboard');
        }

        // 3. Jika MAHASISWA (Student)
        $internship = Internship::with(['documents', 'division', 'mentor.mentorProfile', 'evaluation', 'extensions'])
            ->where('student_id', $user->id)
            ->latest()
            ->first();

        // Jika belum ada data magang ATAU status belum active/finished
        if (!$internship || !in_array($internship->status, ['active', 'finished'])) {
            return view('pending', ['internship' => $internship]);
        }

        // Logic Reset per Jam 7 Pagi (Day starts at 07:00)
        $now = Carbon::now();
        // Jika sebelum jam 7 pagi, anggap masih hari kemarin (untuk display status)
        $dateQuery = $now->hour < 7 ?Carbon::yesterday() : Carbon::today();

        $todayAttendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $dateQuery)
            ->first();

        $todayLogbook = DailyLogbook::where('internship_id', $internship->id)
            ->whereDate('date', $dateQuery)
            ->exists();

        // Ambil Logbook (5 terakhir untuk dashboard)
        $logbooks = DailyLogbook::where('internship_id', $internship->id)
            ->latest('date')
            ->take(5)
            ->get();

        // Hitung Statistik Kehadiran
        $totalWorkingDays = $internship->start_date && $internship->end_date
            ?\Carbon\Carbon::parse($internship->start_date)->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend();
        }, \Carbon\Carbon::now())
            : 0;

        // Prevent division by zero if internship just started today
        $totalWorkingDays = max($totalWorkingDays, 1);

        $totalPresent = Attendance::where('internship_id', $internship->id)
            ->where('status', 'present')
            ->count();

        $totalPermit = Attendance::where('internship_id', $internship->id)
            ->where('status', 'permit')
            ->where(function ($query) {
            $query->where('permit_type', '!=', 'temporary')
                ->orWhereNull('permit_type');
        })
            ->count();

        $totalSick = Attendance::where('internship_id', $internship->id)
            ->where('status', 'sick')
            ->count();

        $attendancePercentage = $totalWorkingDays > 0 ? round(($totalPresent / $totalWorkingDays) * 100) : 0;

        // Attendance Window Logic (for buttons visibility)
        $isCheckInTime = $now->between(
            $now->copy()->setTime(7, 0),
            $now->copy()->setTime(9, 0)
        );
        $isCheckOutTime = $now->between(
            $now->copy()->setTime(17, 0),
            $now->copy()->setTime(19, 0)
        );

        $hasTemporaryPermitToday = $todayAttendance && ($todayAttendance->permit_type === 'temporary' || $todayAttendance->permit_start_time !== null);

        return view('dashboard', [
            'internship' => $internship,
            'logbooks' => $logbooks,
            'todayAttendance' => $todayAttendance,
            'todayLogbook' => $todayLogbook,
            'totalPresent' => $totalPresent,
            'totalPermit' => $totalPermit,
            'totalSick' => $totalSick,
            'attendancePercentage' => $attendancePercentage,
            'isCheckInTime' => $isCheckInTime,
            'isCheckOutTime' => $isCheckOutTime,
            'hasTemporaryPermitToday' => $hasTemporaryPermitToday,
        ]);
    }
}
