<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kategori Routes
    Route::resource('kategoris', KategoriController::class);
    
    // Barang Routes
    Route::resource('barangs', BarangController::class);
    
    // API untuk mendapatkan barang berdasarkan kategori
    Route::get('/api/barangs-by-kategori/{kategoriId}', [BarangController::class, 'getByKategori'])->name('api.barangs.by-kategori');
    
    // Pemeliharaan Routes
    Route::resource('pemeliharaans', PemeliharaanController::class);
    Route::get('pemeliharaans/export/pdf', [PemeliharaanController::class, 'exportPdf'])->name('pemeliharaans.export.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';