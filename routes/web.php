<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogbookController;
use App\Models\Internship;
use App\Models\DailyLogbook;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
use Carbon\Carbon;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $internship = Internship::where('student_id', Auth::id())->first();

    // jika belum punya data magang, send ke halaman setup
    if (!$internship) {
        return redirect()->route('internships.create');
    }

    $logbooks = DailyLogbook::where('internship_id', $internship->id)->latest()->get();

    $todayAttendance = Attendance::where('internship_id', $internship->id)
        ->whereDate('date', Carbon::today())
        ->first();

    return view('dashboard',compact('logbooks', 'todayAttendance'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //route logbook
    Route::get('/logbooks/create', [LogbookController::class, 'create'])->name('logbooks.create');
    Route::post('/logbooks', [LogbookController::class, 'store'])->name('logbooks.store');
    //route profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //route internship
    Route::get('/setup-internship', [InternshipController::class, 'create'])->name('internships.create');
    Route::post('/setup-internship', [InternshipController::class, 'store'])->name('internships.store');
    //route attendance atau absen
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
});

require __DIR__.'/auth.php';