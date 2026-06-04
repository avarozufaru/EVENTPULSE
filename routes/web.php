<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/event/{id}', [HomeController::class, 'detail']);
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'storeRegister']);
Route::get('/logout', [AuthController::class, 'logout']);

// Mahasiswa routes (harus login)
Route::middleware(['auth.login'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/event/{id}/daftar', [RegistrationController::class, 'store']);
    Route::get('/ticket/{kode_tiket}/download', [RegistrationController::class, 'downloadTicket']);
});

// Admin-only login routes (public)
Route::get('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/login', [AuthController::class, 'processAdminLogin']);

// Shared routes for both Admin and Penyelenggara (harus login + staff)
Route::middleware(['auth.login', 'auth.staff'])->group(function () {
    Route::resource('events', EventController::class);
});

// Admin-only routes (harus login + admin)
Route::middleware(['auth.login', 'auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex']);
    Route::get('/admin/peserta', [DashboardController::class, 'peserta']);
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });

    // Kelola User
    Route::get('/admin/users', [AdminController::class, 'userIndex']);
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'userEdit']);
    Route::put('/admin/users/{id}', [AdminController::class, 'userUpdate']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'userDestroy']);

    // Kelola Kategori
    Route::get('/admin/categories', [AdminController::class, 'categoryIndex']);
    Route::post('/admin/categories', [AdminController::class, 'categoryStore']);
    Route::put('/admin/categories/{id}', [AdminController::class, 'categoryUpdate']);
    Route::delete('/admin/categories/{id}', [AdminController::class, 'categoryDestroy']);

    // Verifikasi Event
    Route::get('/admin/verify', [AdminController::class, 'verifyIndex']);
    Route::post('/admin/verify/{id}/approve', [AdminController::class, 'verifyApprove']);
    Route::post('/admin/verify/{id}/reject', [AdminController::class, 'verifyReject']);

    // Laporan
    Route::get('/admin/laporan', [AdminController::class, 'laporan']);
});

// Penyelenggara-only routes (harus login + penyelenggara)
Route::middleware(['auth.login', 'auth.penyelenggara'])->group(function () {
    Route::get('/penyelenggara/dashboard', [DashboardController::class, 'penyelenggaraIndex']);
    Route::get('/penyelenggara/peserta', [DashboardController::class, 'peserta']);
});