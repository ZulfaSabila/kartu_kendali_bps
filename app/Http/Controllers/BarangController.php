<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of barangs.
     */
    public function index(Request $request)
    {
        $query = Barang::with('kategori')
            ->withCount('pemeliharaans')
            ->whereHas('kategori', function($q) {
                $q->whereNull('deleted_at');
            });

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nup_bmn', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('merk_type', 'like', "%{$search}%");
            });
        }

        $barangs = $query->latest()->paginate(15);
        
        return view('barangs.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new barang.
     */
    public function create(Request $request)
    {
        // Mengambil semua kategori untuk dropdown
        $kategoris = Kategori::all();
        
        // Menangkap kategori_id dari parameter URL agar otomatis terpilih di form
        $selectedKategori = $request->query('kategori_id');
        
        return view('barangs.create', compact('kategoris', 'selectedKategori'));
    }

    /**
     * Store a newly created barang in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nup_bmn' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_type' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'pagu_anggaran' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        Barang::create($validated);

        return redirect()->route('barangs.index', ['kategori_id' => $request->kategori_id])
            ->with('success', 'Data barang berhasil ditambahkan!');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori'])->loadCount('pemeliharaans');
        return view('barangs.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barangs.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nup_bmn' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_type' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'pagu_anggaran' => 'required|numeric|min:0',
        ]);

        $barang->update($validated);

        return redirect()->route('barangs.index', ['kategori_id' => $request->kategori_id])
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $kategori_id = $barang->kategori_id;
        $barang->delete();

        return redirect()->route('barangs.index', ['kategori_id' => $kategori_id])
            ->with('success', 'Data barang berhasil dihapus!');
    }

    /**
     * API: Get barangs by kategori (untuk AJAX)
     */
    public function getByKategori($kategoriId)
    {
        $barangs = Barang::where('kategori_id', $kategoriId)
            ->whereHas('kategori', function($q) {
                $q->whereNull('deleted_at');
            })
            ->get(['id', 'nama_barang', 'nup_bmn']);

        return response()->json($barangs);
    }
}