<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\RiwayatAbsensiController;
use App\Http\Controllers\Admin\IzinCutiController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\IzinCutiController as UserIzinCutiController;

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', fn () => redirect()->route('login'));

// ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/riwayat', [RiwayatAbsensiController::class, 'index'])
            ->name('riwayat');

        Route::get('/riwayat/cetak-pdf', [RiwayatAbsensiController::class, 'cetakPdf'])
            ->name('riwayat.pdf');

        Route::get('/izin', [IzinCutiController::class, 'index'])
            ->name('izin.index');

        Route::post('/izin/approve/{id}', [IzinCutiController::class, 'approve'])
            ->name('izin.approve');

        Route::post('/izin/reject/{id}', [IzinCutiController::class, 'reject'])
            ->name('izin.reject');

        Route::get('/izin/cetak-pdf', [IzinCutiController::class, 'cetakPdf'])
            ->name('izin.pdf');

        Route::resource('shift', ShiftController::class)->except(['show']);

        Route::resource('user', AdminUserController::class)->except(['show']);
        Route::put('/user/{id}/update-jatah', [AdminUserController::class, 'updateJatah'])
            ->name('user.updateJatah');
    });

// USER
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/absen/masuk', [UserDashboardController::class, 'absenMasuk'])
            ->name('absen.masuk');

        Route::post('/absen/pulang', [UserDashboardController::class, 'absenPulang'])
            ->name('absen.pulang');

        Route::get('/izin-cuti', [UserIzinCutiController::class, 'index'])
            ->name('izin-cuti.index');

        Route::post('/izin-cuti', [UserIzinCutiController::class, 'store'])
            ->name('izin-cuti.store');
    });
