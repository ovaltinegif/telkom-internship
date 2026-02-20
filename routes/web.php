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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- */

Route::get('/', function () {
    return view('welcome');
});

Route::view('/help', 'help.index')->name('help.index');

// --- ROUTE DASHBOARD PINTAR (SOTIR ROLE) ---
Route::get('/dashboard', [DashboardController::class , 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Group Route untuk Mahasiswa (Logbook, Profile, dll)
Route::middleware('auth')->group(function () {
    // route logbook
    Route::get('/activity', [LogbookController::class , 'index'])->name('logbooks.index');
    Route::get('/logbooks/create', [LogbookController::class , 'create'])->name('logbooks.create');
    Route::post('/logbooks', [LogbookController::class , 'store'])->name('logbooks.store');
    Route::post('/logbooks/upload-image', [LogbookController::class , 'uploadImage'])->name('logbooks.uploadImage');

    // route documents
    Route::get('/documents/transcript', [DocumentController::class , 'transcript'])->name('documents.transcript');
    Route::get('/documents', [DocumentController::class , 'index'])->name('documents.index');

    // route profile
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    // route attendance atau absen
    Route::post('/attendance/check-in', [AttendanceController::class , 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class , 'checkOut'])->name('attendance.checkOut');
    Route::post('/attendance/permission', [AttendanceController::class , 'permission'])->name('attendance.permission');
    Route::get('/attendance/report', [AttendanceController::class , 'downloadReport'])->name('attendance.report');

    // route documents actions
    Route::post('/documents/extension', [DocumentController::class , 'storeExtension'])->name('documents.storeExtension');
    Route::post('/documents/final-report', [DocumentController::class , 'storeFinalReport'])->name('documents.storeFinalReport');
    Route::post('/documents/pakta-integritas', [DocumentController::class , 'storePaktaIntegritas'])->name('documents.storePaktaIntegritas');
});


// Group Route Khusus Mentor (Dashboard Mentor)
Route::prefix('mentor')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard Mentor
    Route::get('/dashboard', [MentorController::class , 'dashboard'])->name('mentor.dashboard');


    // List Mahasiswa
    Route::get('/my-students', [MentorController::class , 'myStudents'])->name('mentor.students.index');

    // Detail Mahasiswa
    Route::get('/student/{id}', [MentorController::class , 'showStudent'])->name('mentor.students.show');
    Route::get('/student/{id}/transcript', [MentorController::class , 'transcript'])->name('mentor.students.transcript');
    Route::get('/student/{id}/monthly-report', [MentorController::class , 'monthlyReport'])->name('mentor.students.monthlyReport');

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