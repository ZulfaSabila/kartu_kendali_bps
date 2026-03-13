<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total kategori
        $totalKategori = Kategori::count();

        // Total barang
        $totalBarang = Barang::count();

        // Total pemeliharaan
        $totalPemeliharaan = Pemeliharaan::count();

        // Total biaya: SUM semua kolom biaya (realisasi per transaksi)
        $totalBiaya = Pemeliharaan::sum('biaya');

        // ID baris terakhir untuk setiap barang
        $lastIds = Pemeliharaan::selectRaw('MAX(id) as last_id')
            ->groupBy('barang_id')
            ->pluck('last_id');

        // Total pagu: satu nilai pagu per barang (dari baris terakhirnya)
        $totalPagu = Pemeliharaan::whereIn('id', $lastIds)->sum('pagu');

        // Sisa anggaran: pagu dikurangi biaya_kumulatif terakhir per barang
        $totalBiayaKumulatif = Pemeliharaan::whereIn('id', $lastIds)->sum('biaya_kumulatif');

        $sisaAnggaran = $totalPagu - $totalBiayaKumulatif;

        // Data kategori — dengan filter search
        $search = $request->get('search');

        $kategoris = Kategori::withCount('barangs')
            ->when($search, function ($query, $search) {
                $query->where('nama_kategori', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(12);

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