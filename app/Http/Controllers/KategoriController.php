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
        return redirect()->route('kategoris.index');
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

    public function show(Kategori $kategori)
    {
        // Untuk kategori, kita arahkan saja ke daftar barang dalam kategori tersebut
        return redirect()->route('barangs.index', ['kategori_id' => $kategori->id]);
    }

    public function edit(Kategori $kategori)
    {
        return redirect()->route('dashboard');
    }

    public function update(Request $request, Kategori $kategori)
    {
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
        try {
            $kategori->delete();

            // SETELAH HAPUS: Kembali ke dashboard karena kategori sudah tidak ada
            return redirect()->route('dashboard')
                            ->with('success', 'Data Kategori berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data barang.');
            }
            throw $e;
        }
    }
}