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
    Route::get('/apar', [AparController::class, 'index'])->name('apar.index');
    Route::get('/apar/data', [AparController::class, 'getData'])->name('apar.data');
    Route::post('/apar/store', [AparController::class, 'store'])->name('apar.store');
    Route::put('/apar/{id}', [AparController::class, 'update'])->name('apar.update');
    Route::get('/apar/{id}/edit', [AparController::class, 'edit'])->name('apar.edit');
    Route::get('/apar/{id}', [AparController::class, 'show'])->name('apar.show');

    Route::get('/apar/export', [AparController::class, 'export'])->name('apar.export');
    Route::get('/apar/{id}', [AparController::class, 'show'])->name('apar.show');
    Route::put('/apar/{id}/close', [AparController::class, 'close'])->name('apar.close');
    
});