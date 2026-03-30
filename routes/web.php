<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        // Kategori Admin
        Route::get('kategoris/trashed', [KategoriController::class, 'trashed'])->name('kategoris.trashed');
        Route::patch('kategoris/{id}/restore', [KategoriController::class, 'restore'])->name('kategoris.restore');
        Route::delete('kategoris/{id}/force-delete', [KategoriController::class, 'forceDelete'])->name('kategoris.force-delete');
        Route::resource('kategoris', KategoriController::class)->only(['store', 'update', 'destroy']);
        
        // Barang Admin
        Route::get('barangs/trashed', [BarangController::class, 'trashed'])->name('barangs.trashed');
        Route::patch('barangs/{id}/restore', [BarangController::class, 'restore'])->name('barangs.restore');
        Route::delete('barangs/{id}/force-delete', [BarangController::class, 'forceDelete'])->name('barangs.force-delete');
        Route::resource('barangs', BarangController::class)->only(['store', 'update', 'destroy']);
        
        // Pemeliharaan Admin
        Route::resource('pemeliharaans', PemeliharaanController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('pemeliharaans/export/pdf', [PemeliharaanController::class, 'exportPdf'])->name('pemeliharaans.export-pdf');
        Route::get('pemeliharaans/export/excel', [PemeliharaanController::class, 'exportExcel'])->name('pemeliharaans.export-excel');

        // User Management Admin
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    });

    // Kategori Routes
    Route::get('kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('kategoris/{kategori}', [KategoriController::class, 'show'])->name('kategoris.show');
    
    // Barang Routes
    Route::get('barangs', [BarangController::class, 'index'])->name('barangs.index');
    Route::get('barangs/{barang}', [BarangController::class, 'show'])->name('barangs.show');
    
    // Pemeliharaan Routes
    Route::get('pemeliharaans', [PemeliharaanController::class, 'index'])->name('pemeliharaans.index');
    
    // API untuk mendapatkan barang berdasarkan kategori
    Route::get('/api/barangs-by-kategori/{kategoriId}', [BarangController::class, 'getByKategori'])->name('api.barangs.by-kategori');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';