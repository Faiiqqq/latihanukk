<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    // ================= ADMIN =================
    Route::middleware('role:admin')->group(function () {
        Route::resource('user', UserController::class);
    });

    // ============== ADMIN & PETUGAS ==========
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('kategori', KategoriController::class);

        Route::put('peminjaman/{id}/ajukan', [PeminjamanController::class, 'ajukan'])
            ->name('peminjaman.ajukan');

        Route::get('pengembalian', [PengembalianController::class, 'index']);
        Route::put('pengembalian/{id}/setujui', [PengembalianController::class, 'setujui'])
            ->name('pengembalian.setujui');
    });

    // ============== SEMUA ROLE =================
    Route::middleware('role:admin,petugas,peminjam')->group(function () {
        Route::resource('peminjaman', PeminjamanController::class);

        Route::put('peminjaman/{id}/ajukan', [PeminjamanController::class, 'ajukan'])
            ->name('peminjaman.ajukan');
    });

    Route::resource('alat', AlatController::class)
        ->middleware('auth');

    Route::middleware('role:admin')->group(function () {
        Route::get('activity-log', [ActivityLogController::class, 'index'])
            ->name('activity.index');
    });

    Route::middleware(['auth', 'role:admin,petugas'])
        ->prefix('laporan')
        ->group(function () {

            Route::get('/', [LaporanController::class, 'index'])
                ->name('laporan.index');

            Route::get('/pdf', [LaporanController::class, 'pdf'])
                ->name('laporan.pdf');
        });
});
