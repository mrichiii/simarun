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
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;

use Illuminate\Http\Request;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;

Route::get('/', function (Request $request) {
    $kodeGedung = $request->input('gedung', 'FST');
    $lantaiNomor = $request->input('lantai', 1);

    $gedungs = Gedung::orderBy('nama_gedung')->get();

    $selectedGedung = Gedung::where('kode_gedung', $kodeGedung)->first();
    if ($selectedGedung) {
        $lantais = Lantai::where('gedung_id', $selectedGedung->id)->orderBy('nomor_lantai')->get();
        $selectedLantai = Lantai::where('gedung_id', $selectedGedung->id)->where('nomor_lantai', $lantaiNomor)->first();
        if (!$selectedLantai) {
            $selectedLantai = $lantais->first();
        }
        $rooms = $selectedLantai ? Ruangan::where('lantai_id', $selectedLantai->id)->orderBy('kode_ruangan')->get() : collect();
    } else {
        $lantais = collect();
        $rooms = Ruangan::with('lantai.gedung')->orderBy('kode_ruangan')->get();
    }

    return view('home', compact('rooms', 'gedungs', 'lantais', 'kodeGedung', 'lantaiNomor'));
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
    
    // Routes Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
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
    Route::resource('/admin/gedung', GedungController::class);
    
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

    // Admin Lantai Index (menampilkan semua lantai dari semua gedung)
    Route::get('/admin/lantai', [LantaiController::class, 'adminIndex'])->name('admin.lantai.index');

    // Admin Ruangan Index (menampilkan semua ruangan dari semua gedung)
    Route::get('/admin/ruangan', [RuanganController::class, 'adminIndex'])->name('admin.ruangan.index');

    // Admin Fasilitas Index (menampilkan semua ruangan untuk manage fasilitas)
    Route::get('/admin/fasilitas', [RuanganController::class, 'adminFasilitasIndex'])->name('admin.fasilitas.index');

    // Laporan Admin
    Route::get('/admin/laporan', [LaporanController::class, 'adminIndex'])->name('laporan.admin-index');
    Route::get('/admin/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/admin/laporan/{id}/edit', [LaporanController::class, 'adminEdit'])->name('laporan.admin-edit');
    Route::put('/admin/laporan/{id}', [LaporanController::class, 'adminUpdate'])->name('laporan.admin-update');

    // Manajemen Mahasiswa
    Route::resource('admin/mahasiswa', MahasiswaController::class)->names([
        'index' => 'admin.mahasiswa.index',
        'create' => 'admin.mahasiswa.create',
        'store' => 'admin.mahasiswa.store',
        'edit' => 'admin.mahasiswa.edit',
        'update' => 'admin.mahasiswa.update',
        'destroy' => 'admin.mahasiswa.destroy',
    ]);
});





