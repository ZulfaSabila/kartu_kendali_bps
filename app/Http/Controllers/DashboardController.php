<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Statistik
        $totalKategori = Kategori::where('user_id', $user->id)->count();
        $totalPemeliharaan = Pemeliharaan::where('user_id', $user->id)->count();
        $totalBiaya = Pemeliharaan::where('user_id', $user->id)->sum('biaya');
        $totalPagu = Pemeliharaan::where('user_id', $user->id)->sum('pagu');
        $sisaAnggaran = $totalPagu - $totalBiaya;
        
        // Data Kategori untuk ditampilkan di dashboard
        $kategoris = Kategori::where('user_id', $user->id)
            ->withCount('pemeliharaans')
            ->latest()
            ->get();
        
        return view('dashboard', compact(
            'totalKategori',
            'totalPemeliharaan',
            'totalBiaya',
            'totalPagu',
            'sisaAnggaran',
            'kategoris'
        ));
    }
}