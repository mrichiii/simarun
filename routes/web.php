<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\LantaiController;

Route::get('/', function () {
    return view('welcome');
});

// Routes Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes Protected (hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
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
});



