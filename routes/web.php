<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use Illuminate\Support\Facades\Route;

// ─── Auth ───────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin Routes ────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware('role.admin')
    ->group(function () {

        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::prefix('barang')->name('barang.')->group(function () {
            Route::get('/', [Admin\BarangController::class, 'index'])->name('index');
            Route::post('/', [Admin\BarangController::class, 'store'])->name('store');
            Route::put('/{barang}', [Admin\BarangController::class, 'update'])->name('update');
            Route::delete('/{barang}', [Admin\BarangController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::get('/', [Admin\TransaksiRequestController::class, 'index'])->name('index');
            Route::patch('/{transaksi}/status', [Admin\TransaksiRequestController::class, 'updateStatus'])
                ->name('update-status');
        });

        Route::prefix('manajemen-user')->name('manajemen-user.')->group(function () {
            Route::get('/', [Admin\ManajemenUserController::class, 'index'])->name('index');
            Route::post('/', [Admin\ManajemenUserController::class, 'store'])->name('store');
            Route::delete('/{user}', [Admin\ManajemenUserController::class, 'destroy'])->name('destroy');
        });

        // 🆕 MENU BARU: Validasi & Approval Peminjaman (Mobil/Ruang) untuk Admin
        Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
            Route::get('/', [Admin\PeminjamanAdminController::class, 'index'])->name('index');
            Route::patch('/{id}/status', [Admin\PeminjamanAdminController::class, 'updateStatus'])->name('update-status');
        });
    });

// ─── Customer Routes ─────────────────────────────────────
Route::prefix('customer')
    ->name('customer.')
    ->middleware('role.customer')
    ->group(function () {

        Route::get('/dashboard', [Customer\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::prefix('katalog')->name('katalog.')->group(function () {
            Route::get('/', [Customer\KatalogController::class, 'index'])->name('index');
        });

        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [Customer\PengajuanController::class, 'index'])->name('index');
            Route::post('/', [Customer\PengajuanController::class, 'store'])->name('store');
        });

        // 🆕 MENU BARU: Request Peminjaman Mobil & Ruang untuk Customer
        // Parameter {jenis} nanti otomatis menangkap data 'mobil' atau 'ruang'
        Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
            Route::get('/{jenis}', [Customer\PeminjamanController::class, 'index'])->name('index');
            Route::post('/', [Customer\PeminjamanController::class, 'store'])->name('store');
        });
    });