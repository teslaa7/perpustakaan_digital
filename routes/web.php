<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\ProfileController;

// ==========================================
// 1. ZONA PUBLIK (Guest & Member)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/buku/{id}', [HomeController::class, 'detailBuku'])->name('buku.detail'); 

// --- Autentikasi ---
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. ZONA PEMINJAM (Member)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // --- Profil User ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // --- Koleksi Pribadi ---
    Route::get('/koleksi', [KoleksiController::class, 'koleksi'])->name('koleksi');
    Route::post('/koleksi/simpan/{id}', [KoleksiController::class, 'store'])->name('koleksi.store');
    Route::delete('/koleksi/hapus/{id}', [KoleksiController::class, 'destroy'])->name('koleksi.destroy');

    // --- Transaksi Peminjaman User ---
    Route::post('/peminjaman/simpan/{id}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/detail/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.detail');
    Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::get('/peminjaman/cetak-struk/{id}', [PeminjamanController::class, 'cetakStruk'])->name('peminjaman.struk');
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat.index');

    // --- Ulasan Buku ---
    Route::post('/ulasan/{bukuId}', [PeminjamanController::class, 'storeUlasan'])->name('ulasan.store');
});


// ==========================================
// 3. ZONA PANEL (Admin & Petugas)
// ==========================================
Route::middleware(['auth', 'role:admin,petugas'])->prefix('admin')->group(function () {
    
    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // --- CETAK PDF (WAJIB DI ATAS RESOURCE BIAR GAK KETIBAN) ---
    Route::get('/buku/unduh-pdf', [BukuController::class, 'unduhPdf'])->name('buku.pdf');
    Route::get('/kategori/unduh-pdf', [KategoriController::class, 'unduhPdf'])->name('kategori.pdf');
    Route::get('/peminjaman/unduh-pdf', [PeminjamanController::class, 'unduhPdf'])->name('peminjaman.pdf');
    // --- Master Data ---
    Route::resource('kategori', KategoriController::class);
    Route::resource('buku', BukuController::class);
    
    // --- Kelola Peminjaman ---
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.status');
    
    // --- Laporan ---
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // ==========================================
    // 4. ZONA VIP (Khusus Admin)
    // ==========================================
    Route::middleware(['role:admin'])->group(function () {
        
        // Manajemen Peminjam (User Biasa)
        Route::get('/user/unduh-pdf', [UserController::class, 'unduhPdf'])->name('user.pdf');
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/user/{id}/status', [UserController::class, 'toggleStatus'])->name('user.status');
        Route::delete('/user/{id}', [UserController::class, 'destroyUser'])->name('user.destroy');
        
        // Manajemen Petugas
        Route::get('/petugas', [UserController::class, 'indexPetugas'])->name('petugas.index'); 
        Route::post('/petugas', [UserController::class, 'storePetugas'])->name('petugas.store'); 
        Route::put('/petugas/{id}', [UserController::class, 'updatePetugas'])->name('petugas.update'); 
        Route::delete('/petugas/{id}', [UserController::class, 'destroyPetugas'])->name('petugas.destroy'); 
        
        // Manajemen Ulasan
        Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
        Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    });
});