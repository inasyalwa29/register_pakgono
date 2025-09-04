<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController; // ✅ WAJIB ditambahkan

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// =====================
// 🔹 REGISTER ROUTE
// =====================
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// =====================
// 🔹 LOGIN ROUTE
// =====================
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'check_login'])->name('login.check');

// =====================
// 🔹 DASHBOARD ROUTE
// =====================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index')
    ->middleware('auth'); // ✅ Lindungi dashboard hanya untuk user login

// =====================
// 🔹 LOGOUT ROUTE (POST) ✅ REKOMENDASI LARAVEL 12
// =====================
Route::post('/logout', [DashboardController::class, 'logout'])->name('dashboard.logout');
