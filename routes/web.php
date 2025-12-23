<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\LantaiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

// Routes Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes Protected (hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/gedung/{gedung_id}', [UserDashboardController::class, 'detailGedung'])->name('user.gedung-detail');
    Route::get('/ruangan/{ruangan_id}', [UserDashboardController::class, 'detailRuangan'])->name('user.ruangan-detail');
    
    // Routes Peminjaman
    Route::get('/booking/my-bookings', [PeminjamanController::class, 'myBookings'])->name('booking.my-bookings');
    Route::get('/booking/create/{ruangan_id}', [PeminjamanController::class, 'create'])->name('booking.create');
    Route::post('/booking/store/{ruangan_id}', [PeminjamanController::class, 'store'])->name('booking.store');
    Route::post('/booking/{peminjaman_id}/cancel', [PeminjamanController::class, 'cancel'])->name('booking.cancel');
    Route::put('/booking/{peminjaman_id}/confirm-cancel', [PeminjamanController::class, 'confirmCancel'])->name('booking.confirm-cancel');

    // Routes Laporan User
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
});

// Routes Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // CRUD Gedung
    Route::resource('gedung', GedungController::class);
    
    // CRUD Lantai
    Route::get('gedung/{gedung_id}/lantai', [LantaiController::class, 'index'])->name('lantai.index');
    Route::get('gedung/{gedung_id}/lantai/create', [LantaiController::class, 'create'])->name('lantai.create');
    Route::post('gedung/{gedung_id}/lantai', [LantaiController::class, 'store'])->name('lantai.store');
    Route::get('gedung/{gedung_id}/lantai/{lantai_id}/edit', [LantaiController::class, 'edit'])->name('lantai.edit');
    Route::put('gedung/{gedung_id}/lantai/{lantai_id}', [LantaiController::class, 'update'])->name('lantai.update');
    Route::delete('gedung/{gedung_id}/lantai/{lantai_id}', [LantaiController::class, 'destroy'])->name('lantai.destroy');
    
    // CRUD Ruangan
    Route::get('gedung/{gedung_id}/lantai/{lantai_id}/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('gedung/{gedung_id}/lantai/{lantai_id}/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('gedung/{gedung_id}/lantai/{lantai_id}/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('gedung/{gedung_id}/lantai/{lantai_id}/ruangan/{ruangan_id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('gedung/{gedung_id}/lantai/{lantai_id}/ruangan/{ruangan_id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('gedung/{gedung_id}/lantai/{lantai_id}/ruangan/{ruangan_id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    
    // Fasilitas Ruangan
    Route::get('gedung/{gedung_id}/lantai/{lantai_id}/ruangan/{ruangan_id}/fasilitas/edit', [FasilitasController::class, 'edit'])->name('fasilitas.edit');
    Route::put('gedung/{gedung_id}/lantai/{lantai_id}/ruangan/{ruangan_id}/fasilitas', [FasilitasController::class, 'update'])->name('fasilitas.update');

    // Laporan Admin
    Route::get('/admin/laporan', [LaporanController::class, 'adminIndex'])->name('laporan.admin-index');
    Route::get('/admin/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/admin/laporan/{id}/edit', [LaporanController::class, 'adminEdit'])->name('laporan.admin-edit');
    Route::put('/admin/laporan/{id}', [LaporanController::class, 'adminUpdate'])->name('laporan.admin-update');
});





