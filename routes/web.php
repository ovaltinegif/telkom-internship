<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogbookController;
use App\Models\Internship;
use App\Models\DailyLogbook;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\EvaluationController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- */

Route::get('/', function () {
    return view('welcome');
});



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
    $internship = Internship::with(['documents', 'division', 'mentor'])->where('student_id', $user->id)->latest()->first();

    // Jika belum ada data magang ATAU status belum active/finished
    if (!$internship || !in_array($internship->status, ['active', 'finished'])) {
        return view('pending', ['internship' => $internship]);
    }

    // Jika FINISHED -> Redirect ke Activity (Logbook), jangan tampilkan Dashboard
    if ($internship->status === 'finished') {
        return redirect()->route('logbooks.index');
    }

    // Jika sudah ada data magang dan status active/finished, tampilkan dashboard mahasiswa normal
    $logbooks = DailyLogbook::where('internship_id', $internship->id)->latest()->get();

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

    // Ambil Logbook
    $logbooks = DailyLogbook::where('internship_id', $internship->id)
        ->latest('date')
        ->take(5) // Ambil 5 terakhir
        ->get();

    // Hitung Statistik Kehadiran
    $totalWorkingDays = $internship->start_date && $internship->end_date
        ?\Carbon\Carbon::parse($internship->start_date)->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend();
        }
            , \Carbon\Carbon::now())
            : 0;

        // Prevent division by zero if internship just started today
        $totalWorkingDays = max($totalWorkingDays, 1);

        $totalPresent = Attendance::where('internship_id', $internship->id)
            ->where('status', 'present')
            ->count();

        $totalPermit = Attendance::where('internship_id', $internship->id)
            ->where('status', 'permit')
            ->count();

        $totalSick = Attendance::where('internship_id', $internship->id)
            ->where('status', 'sick')
            ->count();

        $attendancePercentage = $totalWorkingDays > 0 ? round(($totalPresent / $totalWorkingDays) * 100) : 0;

        return view('dashboard', [
        'internship' => $internship,
        'logbooks' => $logbooks,
        'todayAttendance' => $todayAttendance, // Keep this for daily status
        'todayLogbook' => $todayLogbook, // Keep this for daily status
        'totalPresent' => $totalPresent,
        'totalPermit' => $totalPermit,
        'totalSick' => $totalSick,
        'attendancePercentage' => $attendancePercentage
        ]);
    })->middleware(['auth', 'verified'])->name('dashboard');


// Group Route untuk Mahasiswa (Logbook, Profile, dll)
Route::middleware('auth')->group(function () {
    // route logbook
    Route::get('/activity', [LogbookController::class , 'index'])->name('logbooks.index');
    Route::get('/logbooks/create', [LogbookController::class , 'create'])->name('logbooks.create');
    Route::post('/logbooks', [LogbookController::class , 'store'])->name('logbooks.store');
    Route::post('/logbooks/upload-image', [LogbookController::class , 'uploadImage'])->name('logbooks.uploadImage');

    // route documents (placeholder)
    Route::get('/documents/transcript', function () {
            $internship = \App\Models\Internship::with(['evaluation', 'student.studentProfile', 'division'])->where('student_id', Auth::id())->latest()->first();
            if (!$internship || !$internship->evaluation) {
                abort(404);
            }
            return view('documents.transcript', compact('internship'));
        }
        )->name('documents.transcript');

        Route::get('/documents', function () {
            $internship = \App\Models\Internship::with('evaluation')->where('student_id', Auth::id())->latest()->first();
            $isFinished = $internship && ($internship->status === 'finished' || \Carbon\Carbon::now()->gte($internship->end_date));
            return view('documents.index', compact('internship', 'isFinished'));
        }
        )->name('documents.index');

        // route profile
        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

        // route attendance atau absen
        Route::post('/attendance/check-in', [AttendanceController::class , 'checkIn'])->name('attendance.checkIn');
        Route::post('/attendance/check-out', [AttendanceController::class , 'checkOut'])->name('attendance.checkOut');
        Route::post('/attendance/permission', [AttendanceController::class , 'permission'])->name('attendance.permission');
        Route::get('/attendance/report', [AttendanceController::class , 'downloadReport'])->name('attendance.report');

        // route documents
        Route::post('/documents/extension', [App\Http\Controllers\DocumentController::class , 'storeExtension'])->name('documents.storeExtension');
        Route::post('/documents/final-report', [App\Http\Controllers\DocumentController::class , 'storeFinalReport'])->name('documents.storeFinalReport');
        Route::post('/documents/pakta-integritas', [App\Http\Controllers\DocumentController::class , 'storePaktaIntegritas'])->name('documents.storePaktaIntegritas');
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
        }
        )->name('mentor.dashboard');

        // List Mahasiswa
        Route::get('/my-students', [MentorController::class , 'myStudents'])->name('mentor.students.index');

        // Detail Mahasiswa
        Route::get('/student/{id}', [MentorController::class , 'showStudent'])->name('mentor.students.show');

        // Action Approve/Reject Logbook
        Route::patch('/logbook/{id}/update', [MentorController::class , 'updateLogbook'])->name('mentor.logbook.update');

        // Halaman Approval (List Pending Logbook)
        Route::get('/approvals', [MentorController::class , 'approvals'])->name('mentor.approvals.index');

        // Fitur penilaian mahasiswa
        Route::get('/evaluation/{internship}/create', [EvaluationController::class , 'create'])->name('mentor.evaluations.create');
        Route::post('/evaluation/{internship}', [EvaluationController::class , 'store'])->name('mentor.evaluations.store');
    });

// Group Route Khusus ADMIN (Dengan Perbaikan Syntax)
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class , 'dashboard'])
        ->name('admin.dashboard');

    // Fitur Setup Magang
    Route::get('/internship/create', [AdminController::class , 'createInternship'])
        ->name('admin.internship.create');

    Route::post('/internship', [AdminController::class , 'storeInternship'])
        ->name('admin.internship.store');


    // Fitur Data User
    Route::get('/users', [AdminController::class , 'users'])
        ->name('admin.users.index');

    // Fitur Mentor
    Route::get('/mentors/create', [AdminController::class , 'createMentor'])->name('admin.mentors.create');
    Route::post('/mentors', [AdminController::class , 'storeMentor'])->name('admin.mentors.store');



    // Fitur Monitoring Magang
    Route::get('/internships', [AdminController::class , 'internships'])
        ->name('admin.internships.index');
    Route::get('/internships/{id}', [AdminController::class , 'showInternship'])
        ->name('admin.internships.show');

    // Workflow Actions
    Route::patch('/internships/{id}/approve', [AdminController::class , 'approveInternship'])
        ->name('admin.internships.approve');
    Route::patch('/internships/{id}/activate', [AdminController::class , 'activateInternship'])
        ->name('admin.internships.activate');
    Route::patch('/internships/{id}/reject', [AdminController::class , 'rejectInternship'])->name('admin.internships.reject'); // Rejection Route
    Route::post('/internships/{id}/complete', [AdminController::class , 'completeInternship'])->name('admin.internships.complete'); // Completion Route

    // Extension Workflow
    Route::patch('/internships/{id}/approve-extension', [AdminController::class , 'approveExtension'])->name('admin.internships.approveExtension');
    Route::patch('/internships/{id}/reject-extension', [AdminController::class , 'rejectExtension'])->name('admin.internships.rejectExtension');

});


require __DIR__ . '/auth.php';