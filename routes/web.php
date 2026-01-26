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
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\EvaluationController; 
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

Route::get('/help', function () {
    return view('help.index');
})->name('help.index');

// --- ROUTE DASHBOARD PINTAR (SOTIR ROLE) ---
Route::get('/dashboard', function () {
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
    $internship = Internship::where('student_id', $user->id)->first();

    // Jika belum didaftarkan Admin, tampilkan halaman Pending
    if (!$internship) {
        return view('pending'); 
    }

    // Jika sudah ada data magang, tampilkan dashboard mahasiswa normal
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
    
    // route attendance atau absen
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
}); 

// Group Route Khusus Mentor (Dashboard Mentor)
Route::prefix('mentor')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard Mentor
    Route::get('/dashboard', function () {
        $pendingLogbooks = \App\Models\DailyLogbook::where('status', 'pending')->count();
        
        $internships = \App\Models\Internship::with('student')
            ->where('mentor_id', \Illuminate\Support\Facades\Auth::id())
            ->get();

        return view('mentor.dashboard', compact('pendingLogbooks', 'internships'));
    })->name('mentor.dashboard');  

    // List Mahasiswa
    Route::get('/my-students', [MentorController::class, 'myStudents'])->name('mentor.students.index');
    
    // Detail Mahasiswa
    Route::get('/student/{id}', [MentorController::class, 'showStudent'])->name('mentor.students.show');
    
    // Action Approve/Reject Logbook
    Route::patch('/logbook/{id}/update', [MentorController::class, 'updateLogbook'])->name('mentor.logbook.update');

    // Fitur penilaian mahasiswa
    Route::get('/evaluation/{studentId}/create', [EvaluationController::class, 'create'])->name('mentor.evaluations.create');
    Route::post('/evaluation', [EvaluationController::class, 'store'])->name('mentor.evaluations.store');
});

// Group Route Khusus ADMIN (Dengan Perbaikan Syntax)
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
    
    // Fitur Setup Magang
    Route::get('/internship/create', [AdminController::class, 'createInternship'])
        ->name('admin.internship.create');

    Route::post('/internship', [AdminController::class, 'storeInternship'])
        ->name('admin.internship.store');

    // Fitur Data User
    Route::get('/users', [AdminController::class, 'users'])
        ->name('admin.users.index');

    // Fitur Kelola Divisi
    Route::get('/divisions', [AdminController::class, 'divisions'])
        ->name('admin.divisions.index');
    Route::get('/divisions/create', [AdminController::class, 'createDivision'])
        ->name('admin.divisions.create');
    Route::post('/divisions', [AdminController::class, 'storeDivision'])
        ->name('admin.divisions.store');
    Route::get('/divisions/{id}/edit', [AdminController::class, 'editDivision'])
        ->name('admin.divisions.edit');
    Route::put('/divisions/{id}', [AdminController::class, 'updateDivision'])
        ->name('admin.divisions.update');
    Route::delete('/divisions/{id}', [AdminController::class, 'destroyDivision'])
        ->name('admin.divisions.destroy');

    // Fitur Monitoring Magang
    Route::get('/internships', [AdminController::class, 'internships'])
        ->name('admin.internships.index');
    Route::get('/internships/{id}/edit', [AdminController::class, 'editInternship'])
        ->name('admin.internships.edit');
    Route::put('/internships/{id}', [AdminController::class, 'updateInternship'])
        ->name('admin.internships.update');

});

// --- DEBUG ROUTE ---
Route::get('/debug-db', function () {
    $user = \App\Models\User::with('studentProfile')->first();
    $divisions = \App\Models\Division::all();
    return response()->json([
        'message' => 'Cek Data Database',
        'user_data' => $user,
        'divisions' => $divisions
    ]);
});

require __DIR__.'/auth.php';