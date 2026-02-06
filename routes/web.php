<?php

use App\Models\Schedule;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AparController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleTypeController;
use App\Http\Controllers\InspectionScheduleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;

// Landing page
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/preview/{id}', [EntityController::class, 'preview'])->name('public.preview'); //preview page
Route::get('admin/proxy-awork', [EntityController::class, 'proxyAwork'])->name('admin.proxy.awork');//ambil api awork (set up dulu di env url & token)

// Dashboard (dilindungi oleh middleware 'auth')
Route::middleware(AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/apar', [AparController::class, 'index'])->name('apar.index');
    Route::get('/apar/data', [AparController::class, 'getData'])->name('apar.data');
    Route::post('/apar/store', [AparController::class, 'store'])->name('apar.store');
    Route::put('/apar/{id}', [AparController::class, 'update'])->name('apar.update');
    Route::get('/apar/{id}/edit', [AparController::class, 'edit'])->name('apar.edit');
    Route::get('/apar/{id}', [AparController::class, 'show'])->name('apar.show');
    Route::get('/apar/{id}/cheklist/{inspection_schedule_id}', [AparController::class, 'checklist'])->name('apar.checklist');
    
    
    Route::get('/apar/export', [AparController::class, 'export'])->name('apar.export');
    Route::get('/apar/{id}/qrcode', [AparController::class, 'generateQrCode'])->name('apar.qrcode');

    Route::get('/apar/{id}', [AparController::class, 'show'])->name('apar.show');
    Route::put('/apar/{id}/close', [AparController::class, 'close'])->name('apar.close');


    Route::get('/schedule', [InspectionScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [InspectionScheduleController::class, 'store'])->name('schedule.store');
    // Route::post('/schedule/checklist', [InspectionScheduleController::class, 'checklist'])->name('schedule.checklist');
    Route::get('/schedule/{id}', [InspectionScheduleController::class, 'show'])->name('schedule.show');
    Route::get('/schedule/{schedule}/inspections/json', [InspectionScheduleController::class, 'getInspections'])->name('schedule.inspections');


    Route::put('/schedule/update', [InspectionScheduleController::class, 'update'])->name('schedule.update');

    Route::get('media-data', [MediaController::class, 'getData'])->name('media.data');
    Route::get('schedule-type-data', [ScheduleTypeController::class, 'getData'])->name('schedule-type.data');
    Route::resource('media', MediaController::class)->parameters([
        'media' => 'media' // Memaksa Laravel menggunakan {media} bukan {medium}
    ]);
    Route::resource('location', LocationController::class);
    Route::resource('schedule-type', ScheduleTypeController::class);

    //route realnya di sini
    Route::get('/entities/create', [EntityController::class, 'create'])->name('entities.create');
    Route::get('/entities/edit/{id}', [EntityController::class, 'edit'])->name('entities.edit');
    Route::get('entities/{id}/copy', [EntityController::class, 'copy'])->name('entities.copy');
    Route::get('entities/{id}/download-qr', [EntityController::class, 'downloadQR'])->name('entities.download-qr');
    Route::apiResource('entities', EntityController::class);

    Route::apiResource('items', ItemController::class);
    Route::apiResource('transactions', TransactionController::class);
    
});