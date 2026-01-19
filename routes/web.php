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
use App\Http\Controllers\MentorController;
use App\Models\User;
use App\Models\Division;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard Mahasiswa
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

    return view('dashboard', compact('logbooks', 'todayAttendance'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Group Route untuk Mahasiswa (Logbook, Profile, dll)
Route::middleware('auth')->group(function () {
    // route logbook
    Route::get('/logbooks/create', [LogbookController::class, 'create'])->name('logbooks.create');
    Route::post('/logbooks', [LogbookController::class, 'store'])->name('logbooks.store');
    
    // route profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // route internship
    Route::get('/setup-internship', [InternshipController::class, 'create'])->name('internships.create');
    Route::post('/setup-internship', [InternshipController::class, 'store'])->name('internships.store');
    
    // route attendance atau absen
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
}); 

    // Group Route Khusus Mentor (Dashboard Mentor)
Route::prefix('mentor')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard Mentor
    Route::get('/dashboard', function () {
        $pendingLogbooks = \App\Models\DailyLogbook::where('status', 'pending')->count();
        return view('mentor.dashboard', compact('pendingLogbooks'));
    })->name('mentor.dashboard');   

    // List Mahasiswa
    Route::get('/my-students', [App\Http\Controllers\MentorController::class, 'myStudents'])->name('mentor.students.index');
    
    // Detail Mahasiswa (Logbook & Absen)
    Route::get('/student/{id}', [App\Http\Controllers\MentorController::class, 'showStudent'])->name('mentor.students.show');
    
    // Action Approve/Reject Logbook
    Route::patch('/logbook/{id}/update', [App\Http\Controllers\MentorController::class, 'updateLogbook'])->name('mentor.logbook.update');

    // Fitur penilaian mahasiswa oleh mentor
    Route::get('/evaluation/{studentId}/create', [App\Http\Controllers\EvaluationController::class, 'create'])->name('mentor.evaluations.create');
    Route::post('/evaluation', [App\Http\Controllers\EvaluationController::class, 'store'])->name('mentor.evaluations.store');
});

    // --- START DEBUG ROUTE ---
    Route::get('/debug-db', function () {
        // Cek user pertama dan relasi profilnya
        $user = \App\Models\User::with('studentProfile')->first();
        
        // Cek data divisi
        $divisions = \App\Models\Division::all();

        return response()->json([
            'message' => 'Cek Data Database',
            'user_data' => $user,
            'divisions' => $divisions
        ]);
});

require __DIR__.'/auth.php';