<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
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

        // Total biaya: SUM semua kolom biaya (realisasi per transaksi)
        $totalBiaya = Pemeliharaan::whereHas('barang.kategori', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('biaya');

        // ID baris terakhir untuk setiap barang milik user ini
        $lastIds = Pemeliharaan::whereHas('barang.kategori', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->selectRaw('MAX(id) as last_id')
            ->groupBy('barang_id')
            ->pluck('last_id');

        // Total pagu: satu nilai pagu per barang (dari baris terakhirnya)
        $totalPagu = Pemeliharaan::whereIn('id', $lastIds)->sum('pagu');

        // Sisa anggaran: pagu dikurangi biaya_kumulatif terakhir per barang
        $totalBiayaKumulatif = Pemeliharaan::whereIn('id', $lastIds)->sum('biaya_kumulatif');

        $sisaAnggaran = $totalPagu - $totalBiayaKumulatif;

        // Data kategori — dengan filter search
        $search = $request->get('search');

        $kategoris = Kategori::where('user_id', $user->id)
            ->withCount('barangs')
            ->when($search, function ($query, $search) {
                $query->where('nama_kategori', 'like', '%' . $search . '%');
            })
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