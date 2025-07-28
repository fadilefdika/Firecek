<?php

use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AparController;
use App\Http\Controllers\AuthController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (dilindungi oleh middleware 'auth')
Route::middleware(AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports', [AparController::class, 'index'])->name('apar.index');
    Route::get('/reports/data', [AparController::class, 'getData'])->name('apar.data');
    Route::get('/reports/export', [AparController::class, 'export'])->name('apar.export');
    Route::get('/reports/{id}', [AparController::class, 'show'])->name('apar.show');
    Route::put('/reports/{id}/close', [AparController::class, 'close'])->name('apar.close');
    
});