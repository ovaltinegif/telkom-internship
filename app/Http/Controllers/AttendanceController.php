<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Internship;
use carbon\carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Fungsi CHECK-IN (Datang)
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship || $internship->status !== 'active') {
             return back()->with('error', 'Status magang belum aktif.');
        }

        // Cek apakah hari ini sudah absen?
        $existingAttendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if ($existingAttendance) {
            return back()->with('error', 'Kamu sudah check-in hari ini!');
        }

        Attendance::create([
            'internship_id' => $internship->id,
            'date' => Carbon::today(),
            'check_in_time' => Carbon::now()->format('H:i:s'),
            'check_in_lat' => $request->latitude,
            'check_in_long' => $request->longitude,
            'status' => 'present',
        ]);

        return back()->with('success', 'Berhasil Check-in! Semangat kerjanya.');
    }

    // Fungsi CHECK-OUT (Pulang)
    public function checkOut(Request $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        // Cari absen hari ini yang belum di-checkout
        $attendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Kamu belum check-in hari ini!');
        }

        $attendance->update([
            'check_out_time' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Berhasil Check-out! Hati-hati di jalan.');
    }
}
