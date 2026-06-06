<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProyekController;

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute untuk Guest (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute untuk Auth (Hanya bisa diakses jika SUDAH login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/laporan', [ProyekController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/pdf', [ProyekController::class, 'cetakPDF'])->name('laporan.pdf');

    // RUTE CRUD PROYEK
    Route::prefix('proyek')->name('proyek.')->group(function () {
        Route::get('/', [ProyekController::class, 'index'])->name('index');
        Route::get('/create', [ProyekController::class, 'create'])->name('create');
        Route::post('/', [ProyekController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProyekController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProyekController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProyekController::class, 'destroy'])->name('destroy');
    });
});