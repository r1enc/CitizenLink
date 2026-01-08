<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController; 
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KomunitasController; 
use Illuminate\Support\Facades\Route;


// --- 1. JALUR UMUM (PUBLIC) ---
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/jelajah', [LandingController::class, 'feed'])->name('feed');
Route::get('/panduan', [LandingController::class, 'panduan'])->name('panduan');
Route::get('/tracking/{id}', [LaporanController::class, 'showPublic'])->name('laporan.tracking');
Route::get('/cari-laporan', [LaporanController::class, 'cariLaporan'])->name('laporan.search');

// --- 2. JALUR KHUSUS (HARUS LOGIN) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Laporan & Upvote
    Route::post('/pengaduan', [LaporanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan-berhasil/{id}', [LaporanController::class, 'sukses'])->name('pengaduan.sukses');
    Route::post('/laporan/{id}/upvote', [LaporanController::class, 'upvote'])->name('laporan.upvote');
    Route::post('/cek-duplikat', [LaporanController::class, 'cekDuplikat'])->name('laporan.cek_duplikat');
    Route::patch('/laporan/{id}/status', [LaporanController::class, 'updateStatus'])->name('laporan.update_status');

    // --- FITUR ADMIN: KELOLA PETUGAS, TIMELINE, & DUPLIKAT ---
    Route::get('/admin/petugas', [DashboardController::class, 'kelolaPetugas'])->name('admin.petugas');
    Route::post('/admin/petugas', [DashboardController::class, 'storePetugas'])->name('admin.petugas.store'); 
    Route::delete('/admin/petugas/{id}', [DashboardController::class, 'destroyPetugas'])->name('admin.petugas.destroy'); 
    
    Route::get('/admin/timeline', [DashboardController::class, 'timeline'])->name('admin.timeline');
    
    //  ROUTE BUAT HALAMAN DUPLIKAT (ADMIN)
    Route::get('/admin/laporan-duplikat', [DashboardController::class, 'laporanDuplikat'])->name('admin.laporan.duplikat');
    
    // Komunitas Routes
    Route::get('/komunitas', [KomunitasController::class, 'index'])->name('komunitas');
    Route::get('/komunitas/buat', [KomunitasController::class, 'create'])->name('komunitas.create');
    Route::post('/komunitas', [KomunitasController::class, 'store'])->name('komunitas.store');
    Route::post('/komunitas/{id}/upvote', [KomunitasController::class, 'upvote'])->name('diskusi.upvote');
    Route::get('/komunitas/{id}', [KomunitasController::class, 'show'])->name('komunitas.show');
    Route::post('/komunitas/{id}/komentar', [KomunitasController::class, 'storeKomentar'])->name('komunitas.komentar.store');
    
    //id laporan
    Route::post('/laporan/{id}/ambil', [LaporanController::class, 'ambilLaporan'])->name('laporan.ambil');
    Route::post('/laporan/{id}/lepas', [LaporanController::class, 'lepasLaporan'])->name('laporan.lepas');
    Route::get('/petugas/tugas', [DashboardController::class, 'tugasSaya'])->name('petugas.tugas');
    
    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/laporan/{id}/selesaikan', [LaporanController::class, 'selesaikanLaporan'])->name('laporan.selesaikan');
    Route::get('/tugas-saya', [LaporanController::class, 'tugasSaya'])->name('tugas.saya');
});

require __DIR__.'/auth.php';