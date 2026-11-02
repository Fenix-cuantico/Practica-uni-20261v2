<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherScheduleController;
use App\Http\Controllers\StudentScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', RoleMiddleware::class])->name('dashboard');

Route::middleware(['auth', RoleMiddleware::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/pdf', [ProfileController::class, 'viewPdf'])->name('profile.pdf.view');
    Route::get('/profile/pdf/download', [ProfileController::class, 'downloadPdf'])->name('profile.pdf.download');
    
    Route::post('/profile/family-members', [\App\Http\Controllers\FamilyMemberController::class, 'store'])->name('family-members.store');
    Route::delete('/profile/family-members/{id}', [\App\Http\Controllers\FamilyMemberController::class, 'destroy'])->name('family-members.destroy');
});

// Auth & Role restricted routes for Phase 4 & System
Route::middleware(['auth', RoleMiddleware::class])->group(function () {
    Route::get('/asistencia', function () {
        return view('attendances.create');
    })->name('attendances.create');
    
    Route::get('/horarios', [TeacherScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/api/schedules/{schedule}/enrolled', [TeacherScheduleController::class, 'getStudents'])->name('schedule.students');
    
    Route::get('/mis-cursos', [StudentScheduleController::class, 'index'])->name('student.courses');

    Route::post('/api/attendances', [AttendanceController::class, 'store']);
    Route::get('/api/schedules/{schedule}/students', [\App\Http\Controllers\Api\StudentAttendanceController::class, 'getStudents']);
    Route::post('/api/schedules/{schedule}/students/attendances', [\App\Http\Controllers\Api\StudentAttendanceController::class, 'saveAttendances']);
});

Route::get('/reports/teacher/{teacher}/load', [ReportController::class, 'teacherLoad'])->name('reports.teacher_load');
Route::get('/reports/students/export', [ReportController::class, 'exportStudents'])->name('reports.students_export');

// Dev Routes for Fast Dual Registrations
Route::get('/dev/register', [\App\Http\Controllers\DevController::class, 'showRegistrationForm'])->name('dev.register');
Route::post('/dev/register', [\App\Http\Controllers\DevController::class, 'register'])->name('dev.register.post');

require __DIR__.'/auth.php';
