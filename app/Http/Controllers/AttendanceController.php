<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Internship;
use App\Http\Requests\CheckInRequest;
use App\Http\Requests\PermissionRequest;
use carbon\carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Fungsi CHECK-IN (Datang)
    public function checkIn(CheckInRequest $request)
    {
        $internship = Internship::where('student_id', Auth::id())->active()->first();

        if (!$internship) {
            return back()->with('error', 'Status magang belum aktif atau tidak ditemukan.');
        }

        if ($internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi presensi atau logbook.');
        }

        // Time Validation: 07:00 - 09:00
        $now = Carbon::now();
        $startCheckIn = $now->copy()->hour(7)->minute(0)->second(0);
        $endCheckIn = $now->copy()->hour(9)->minute(0)->second(0);

        if (!$now->between($startCheckIn, $endCheckIn)) {
            return back()->with('error', 'Check-in hanya dapat dilakukan antara pukul 07:00 - 09:00 WIB.');
        }

        // Cek apakah hari ini sudah absen? (Logic Reset jam 7 pagi)
        $dateCheck = Carbon::now()->hour < 7 ?Carbon::yesterday() : Carbon::today();

        $existingAttendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $dateCheck)
            ->first();

        if ($existingAttendance) {
            // Logic Izin Sementara: Boleh check-in jika jam izin sudah lewat
            if ($existingAttendance->status === 'permit' && $existingAttendance->permit_type === 'temporary') {
                $permitEndTime = Carbon::parse($existingAttendance->date . ' ' . $existingAttendance->permit_end_time);

                if (Carbon::now()->lt($permitEndTime)) {
                    return back()->with('error', 'Anda masih dalam jam izin sementara. Check-in baru bisa dilakukan setelah ' . $permitEndTime->format('H:i'));
                }

                // Update record yang sudah ada, jangan buat baru
                $existingAttendance->update([
                    'check_in_time' => Carbon::now()->format('H:i:s'),
                    'check_in_lat' => $request->latitude,
                    'check_in_long' => $request->longitude,
                    'status' => 'present', // Ubah status jadi hadir (atau bisa tetap permit dengan catatan)
                ]);

                return back()->with('success', 'Berhasil Check-in setelah izin sementara!');
            }

            return back()->with('error', 'Kamu sudah check-in hari ini!');
        }

        Attendance::create([
            'internship_id' => $internship->id,
            'date' => $dateCheck,
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

        if ($internship && $internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi presensi atau logbook.');
        }

        // Cari absen hari ini yang belum di-checkout (Logic Reset 7 Pagi)
        $dateCheck = Carbon::now()->hour < 7 ?Carbon::yesterday() : Carbon::today();

        $attendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $dateCheck)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Kamu belum check-in hari ini!');
        }

        // Time Validation: 17:00 - 19:00
        $now = Carbon::now();
        $startCheckOut = $now->copy()->hour(17)->minute(0)->second(0);
        $endCheckOut = $now->copy()->hour(19)->minute(0)->second(0);

        if (!$now->between($startCheckOut, $endCheckOut)) {
            return back()->with('error', 'Check-out hanya dapat dilakukan antara pukul 17:00 - 19:00 WIB.');
        }

        // Silent Block: Jika izin full day, jangan lakukan apa-apa
        if ($attendance->status === 'permit' && $attendance->permit_type === 'full') {
            return back();
        }

        $attendance->update([
            'check_out_time' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Berhasil Check-out! Hati-hati di jalan.');
    }

    // Fungsi IZIN (Permission)
    public function permission(PermissionRequest $request)
    {
        $internship = Internship::where('student_id', Auth::id())->active()->first();

        if (!$internship) {
            return back()->with('error', 'Status magang tidak aktif atau tidak ditemukan.');
        }

        if ($internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi presensi atau logbook.');
        }

        // Check if attendance exists for date
        $existingAttendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $request->date)
            ->first();

        if ($existingAttendance) {
            // Allow update ONLY if permit_type is 'temporary' (Half-day)
            if ($request->permit_type === 'temporary') {
                $attachmentPath = $existingAttendance->attachment;
                if ($request->hasFile('attachment')) {
                    $attachmentPath = $request->file('attachment')->store('permissions', 'public');
                }

                $existingAttendance->update([
                    'status' => 'permit',
                    'permit_type' => 'temporary',
                    'permit_start_time' => $request->start_time,
                    'permit_end_time' => $request->end_time,
                    'note' => $request->note,
                    'attachment' => $attachmentPath,
                ]);

                return back()->with('success', 'Pengajuan izin sementara berhasil disimpan.');
            }

            return back()->with('error', 'Absensi/Izin untuk tanggal ini sudah ada.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('permissions', 'public');
        }

        Attendance::create([
            'internship_id' => $internship->id,
            'date' => $request->date,
            'status' => 'permit', // Set as permit
            'permit_type' => $request->permit_type,
            'permit_start_time' => $request->permit_type === 'temporary' ? $request->start_time : null,
            'permit_end_time' => $request->permit_type === 'temporary' ? $request->end_time : null,
            'note' => $request->note,
            'attachment' => $attachmentPath,
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    // Fungsi Laporan Bulanan (Monthly Report)
    public function downloadReport(Request $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard');
        }

        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        // Get attendances
        $attendances = Attendance::where('internship_id', $internship->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        // Get logbooks
        $logbooks = \App\Models\DailyLogbook::where('internship_id', $internship->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        // If no view exists yet, we can create one.
        // For now, assume we will create 'reports.monthly'
        return view('reports.monthly', compact('internship', 'attendances', 'logbooks', 'month', 'year'));
    }
}
