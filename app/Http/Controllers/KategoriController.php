<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Method index bisa dinonaktifkan atau diarahkan ke dashboard
    public function index()
    {
        return redirect()->route('dashboard');
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

        // Langsung arahkan ke Dashboard setelah tambah kategori
        return redirect()->route('dashboard')
                        ->with('success', 'Data Kategori berhasil ditambahkan!');
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

        // SETELAH EDIT: Kembali ke halaman barang kategori tersebut, bukan ke kelola kategori
        return redirect()->route('dashboard', ['kategori_id' => $kategori->id])
                        ->with('success', 'Data kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->user_id !== auth()->id()) {
            abort(403);
        }

        $kategori->delete();

        // SETELAH HAPUS: Kembali ke dashboard karena kategori sudah tidak ada
        return redirect()->route('dashboard')
                        ->with('success', 'Data Kategori dan seluruh aset di dalamnya berhasil dihapus!');
    }
}