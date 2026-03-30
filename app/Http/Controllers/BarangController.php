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
            ->withSum('pemeliharaans', 'biaya')
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
        $kategoris = Kategori::all();
        
        return view('barangs.index', compact('barangs', 'kategoris'));
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
            'pagu_anggaran' => 'required|numeric|min:1',
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

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nup_bmn' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_type' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'pagu_anggaran' => 'required|numeric|min:1',
        ]);

        $barang->update($validated);

        // SINKRONISASI MASAL: Mengubah pagu di Inventaris akan mengubah seluruh riwayat
        $barang->pemeliharaans()->update(['pagu' => $barang->pagu_anggaran]);

        return redirect()->route('barangs.index', ['kategori_id' => $request->kategori_id])
            ->with('success', 'Data barang dan seluruh riwayat pagu berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return redirect()->route('barangs.index')
                ->with('success', 'Barang berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()
                    ->with('error', 'Barang tidak dapat dihapus karena masih memiliki riwayat pemeliharaan. Hapus semua riwayat pemeliharaan terlebih dahulu.');
            }
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus barang. Silakan coba lagi.');
        }
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

    /**
     * Display a listing of soft-deleted barangs.
     */
    public function trashed(Request $request)
    {
        $query = Barang::onlyTrashed()
            ->with('kategori')
            ->whereHas('kategori', function($q) {
                $q->whereNull('deleted_at');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nup_bmn', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('merk_type', 'like', "%{$search}%");
            });
        }

        $barangs = $query->latest()->paginate(15);
        
        return view('barangs.trashed', compact('barangs'));
    }

    /**
     * Restore a soft-deleted barang.
     */
    public function restore($id)
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);
        $barang->restore();

        return redirect()->route('barangs.index')
            ->with('success', 'Data barang berhasil dipulihkan.');
    }

    /**
     * Permanently delete a soft-deleted barang.
     */
    public function forceDelete($id)
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);
        
        // Hapus juga riwayat pemeliharaannya secara permanen
        $barang->pemeliharaans()->forceDelete();
        $barang->forceDelete();

        return redirect()->route('barangs.trashed')
            ->with('success', 'Data barang dan riwayat pemeliharaannya telah dihapus secara permanen.');
    }
}