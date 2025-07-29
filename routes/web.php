<?php

use App\Models\Schedule;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AparController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleTypeController;
use App\Http\Controllers\InspectionScheduleController;

// Landing page
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (dilindungi oleh middleware 'auth')
Route::middleware(AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/apar', [AparController::class, 'index'])->name('apar.index');
    Route::get('/apar/data', [AparController::class, 'getData'])->name('apar.data');
    Route::post('/apar/store', [AparController::class, 'store'])->name('apar.store');
    Route::put('/apar/{id}', [AparController::class, 'update'])->name('apar.update');
    Route::get('/apar/{id}/edit', [AparController::class, 'edit'])->name('apar.edit');
    Route::get('/apar/{id}', [AparController::class, 'show'])->name('apar.show');

    Route::get('/apar/export', [AparController::class, 'export'])->name('apar.export');
    Route::get('/apar/{id}', [AparController::class, 'show'])->name('apar.show');
    Route::put('/apar/{id}/close', [AparController::class, 'close'])->name('apar.close');


    Route::get('/schedule', [InspectionScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [InspectionScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/update', [InspectionScheduleController::class, 'update'])->name('schedule.update');

    Route::get('media-data', [MediaController::class, 'getData'])->name('media.data');
    Route::resource('media', MediaController::class);
    Route::resource('location', LocationController::class);
    Route::resource('schedule-type', ScheduleTypeController::class);
    
});