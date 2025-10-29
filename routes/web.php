<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananDetailController;
use App\Http\Controllers\TransaksiController;

// ======================================
// HALAMAN AWAL
// ======================================
Route::get('/', function () {
    return view('welcome');
});

// ======================================
// AUTH (Login / Logout / Me info)
// ======================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth');

// ======================================
// ADMIN - Kelola Meja & Menu
// ======================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // CRUD Meja
    Route::resource('meja', MejaController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // CRUD Menu
    Route::resource('menu', MenuController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // CRUD Users
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// ======================================
// WAITER - Kelola Pesanan & Detail Pesanan
// ======================================
Route::middleware(['auth'])->prefix('waiter')->name('waiter.')->group(function () {
    Route::get('/', [WaiterController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [WaiterController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/print', [WaiterController::class, 'laporan'])->name('laporan.print');

    // CRUD Pesanan
    Route::resource('pesanan', PesananController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // CRUD Pesanan Detail
    Route::resource('pesanan-detail', PesananDetailController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // Pelanggan
    Route::resource('pelanggan', PelangganController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// ======================================
// KASIR - Kelola Transaksi Pembayaran
// ======================================
Route::middleware(['auth'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('dashboard');

    // CRUD Transaksi
    Route::resource('transaksi', TransaksiController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::get('transaksi/{transaksi}/print', [TransaksiController::class, 'print'])->name('transaksi.print');

        // Tambahan fitur laporan kasir
        Route::get('/pesanan-siap-bayar', [KasirController::class, 'pesananSiapBayar'])->name('siap-bayar');
        Route::get('/hari-ini', [KasirController::class, 'hariIni'])->name('hari-ini');
        Route::get('/hari-ini/print', [KasirController::class, 'hariIni'])->name('hari-ini.print');
});

// ======================================
// OWNER - Dashboard & Laporan
// ======================================
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/', [OwnerController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [OwnerController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/print', [OwnerController::class, 'laporanPrint'])->name('laporan.print');
});
