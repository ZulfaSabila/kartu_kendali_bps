<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Pemeliharaan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total kategori
        $totalKategori = Kategori::where('user_id', $user->id)->count();

        // Total barang
        $totalBarang = Barang::whereHas('kategori', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        // Total pemeliharaan
        $totalPemeliharaan = Pemeliharaan::whereHas('barang.kategori', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        // Total biaya pemeliharaan
        $totalBiaya = Pemeliharaan::whereHas('barang.kategori', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('biaya');

        // Total pagu (diasumsikan ada di tabel pemeliharaans)
        $totalPagu = Pemeliharaan::whereHas('barang.kategori', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('pagu');

        // Sisa anggaran
        $sisaAnggaran = $totalPagu - $totalBiaya;

        // Data kategori + jumlah barang
        $kategoris = Kategori::where('user_id', $user->id)
            ->withCount('barangs')
            ->latest()
            ->get();

        return view('dashboard', compact(
            'totalKategori',
            'totalBarang',
            'totalPemeliharaan',
            'totalBiaya',
            'totalPagu',
            'sisaAnggaran',
            'kategoris'
        ));
    }
}
