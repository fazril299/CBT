<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DutyMemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Schedules (CRUD for Admin, View for All)
    Route::resource('schedules', ScheduleController::class);
    Route::post('/schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.status');

    // Duty Members (Assign/Remove members from schedule & Toggle PJ)
    Route::post('/schedules/{schedule}/members', [DutyMemberController::class, 'store'])->name('duty-members.store');
    Route::post('/duty-members/{dutyMember}/toggle-pj', [DutyMemberController::class, 'togglePj'])->name('duty-members.toggle-pj');
    Route::delete('/duty-members/{dutyMember}', [DutyMemberController::class, 'destroy'])->name('duty-members.destroy');

    // Attendance & Verification
    Route::post('/attendances/update/{dutyMember}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::post('/attendances/submit-proof/{dutyMember}', [AttendanceController::class, 'submitProof'])->name('attendances.submit-proof');
    Route::post('/attendances/verify/{dutyMember}', [AttendanceController::class, 'verify'])->name('attendances.verify');

    // Activities (Pembuatan Kegiatan Piket & Checklist)
    Route::resource('activities', ActivityController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::post('/activities/{activity}/toggle', [ActivityController::class, 'toggleComplete'])->name('activities.toggle');
});

require __DIR__.'/auth.php';
