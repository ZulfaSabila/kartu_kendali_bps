<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::where('user_id', auth()->id())
                            ->withCount('pemeliharaans')
                            ->latest()
                            ->paginate(10);
        
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();

        Kategori::create($validated);

        return redirect()->route('kategoris.index')
                        ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(Kategori $kategori)
    {
        // Pastikan user hanya bisa akses kategori miliknya
        if ($kategori->user_id !== auth()->id()) {
            abort(403);
        }

        $pemeliharaans = $kategori->pemeliharaans()
                                 ->latest()
                                 ->paginate(10);
        
        $totalBiaya = $kategori->pemeliharaans()->sum('biaya');
        $totalPagu = $kategori->pemeliharaans()->sum('pagu');
        $sisaAnggaran = $totalPagu - $totalBiaya;

        return view('kategoris.show', compact('kategori', 'pemeliharaans', 'totalBiaya', 'totalPagu', 'sisaAnggaran'));
    }

    public function edit(Kategori $kategori)
    {
        if ($kategori->user_id !== auth()->id()) {
            abort(403);
        }

        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        if ($kategori->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update($validated);

        return redirect()->route('kategoris.index')
                        ->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->user_id !== auth()->id()) {
            abort(403);
        }

        $kategori->delete();

        return redirect()->route('kategoris.index')
                        ->with('success', 'Kategori berhasil dihapus!');
    }
}