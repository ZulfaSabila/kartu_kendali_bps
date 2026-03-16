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
        // Statistics for cards
        $totalKategori = Kategori::count();
        $kategoriFilled = Kategori::has('barangs')->count();
        $kategoriTerbanyak = Kategori::withCount('barangs')
            ->orderBy('barangs_count', 'desc')
            ->first();

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
            'kategoriFilled',
            'kategoriTerbanyak',
            'kategoris'
        ));
    }
}