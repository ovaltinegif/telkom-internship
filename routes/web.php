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
    Route::get('/logbooks/export-pdf', [LogbookController::class , 'exportPdf'])->name('logbooks.exportPdf');
    Route::get('/logbooks/export-excel', [LogbookController::class , 'exportExcel'])->name('logbooks.exportExcel');
    Route::controller(LogbookController::class)->group(function () {
            Route::get('/activity', 'index')->name('logbooks.index');
            Route::get('/logbooks/create', 'create')->name('logbooks.create');
            Route::post('/logbooks', 'store')->name('logbooks.store');
            Route::post('/logbooks/upload-image', 'uploadImage')->name('logbooks.uploadImage');
        }
        );

        // route documents
        Route::controller(DocumentController::class)->group(function () {
            Route::get('/documents/transcript', 'transcript')->name('documents.transcript');
            Route::get('/documents', 'index')->name('documents.index');
            Route::post('/documents/extension', 'storeExtension')->name('documents.storeExtension');
            Route::post('/documents/final-report', 'storeFinalReport')->name('documents.storeFinalReport');
            Route::post('/documents/pakta-integritas', 'storePaktaIntegritas')->name('documents.storePaktaIntegritas');
        }
        );

        // route profile
        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

        // route attendance atau absen
        Route::controller(AttendanceController::class)->group(function () {
            Route::post('/attendance/check-in', 'checkIn')->name('attendance.checkIn');
            Route::post('/attendance/check-out', 'checkOut')->name('attendance.checkOut');
            Route::post('/attendance/permission', 'permission')->name('attendance.permission');
            Route::get('/attendance/report', 'downloadReport')->name('attendance.report');
        }
        );
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
    Route::patch('/logbooks/mass-approve', [MentorController::class , 'massApproveLogbooks'])->name('mentor.logbook.massApprove');
    Route::patch('/logbook/{id}/update', [MentorController::class , 'updateLogbook'])->name('mentor.logbook.update');

    // Halaman Approval (List Pending Logbook)
    Route::get('/approvals', [MentorController::class , 'approvals'])->name('mentor.approvals.index');

    // Fitur penilaian mahasiswa
    Route::get('/evaluation/{internship}/create', [EvaluationController::class , 'create'])->name('mentor.evaluations.create');
    Route::post('/evaluation/{internship}', [EvaluationController::class , 'store'])->name('mentor.evaluations.store');
});

// Group Route Khusus ADMIN (Dengan Perbaikan Syntax)
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
            // Dashboard Admin
            Route::get('/dashboard', 'dashboard')->name('admin.dashboard');

            // Fitur Setup Magang
            Route::get('/internship/create', 'createInternship')->name('admin.internship.create');
            Route::post('/internship', 'storeInternship')->name('admin.internship.store');

            // Fitur Data User
            Route::get('/users', 'users')->name('admin.users.index');

            // Fitur Mentor
            Route::get('/mentors/create', 'createMentor')->name('admin.mentors.create');
            Route::post('/mentors', 'storeMentor')->name('admin.mentors.store');

            // Fitur Monitoring Magang
            Route::get('/internships', 'internships')->name('admin.internships.index');
            Route::get('/internships/{id}', 'showInternship')->name('admin.internships.show');

            // Workflow Actions
            Route::patch('/internships/{id}/approve', 'approveInternship')->name('admin.internships.approve');
            Route::patch('/internships/{id}/activate', 'activateInternship')->name('admin.internships.activate');
            Route::patch('/internships/{id}/reject', 'rejectInternship')->name('admin.internships.reject');
            Route::post('/internships/{id}/complete', 'completeInternship')->name('admin.internships.complete');

            // Extension Workflow
            Route::patch('/internships/{id}/approve-extension', 'approveExtension')->name('admin.internships.approveExtension');
            Route::patch('/internships/{id}/reject-extension', 'rejectExtension')->name('admin.internships.rejectExtension');
        }
        );
    });


require __DIR__ . '/auth.php';