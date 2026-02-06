<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemeliharaanExport;

class PemeliharaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemeliharaan::where('user_id', auth()->id())
                            ->with('kategori');

        if (!$request->hasAny(['search', 'kategori_id', 'tanggal_mulai', 'tanggal_selesai'])) {
            $firstKategoriId = Pemeliharaan::where('user_id', auth()->id())
                                          ->orderBy('kategori_id')
                                          ->value('kategori_id');
            
            if ($firstKategoriId) {
                $query->where('kategori_id', $firstKategoriId);
            }
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nup_bmn', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('rincian_pekerjaan', 'like', "%{$search}%");
            });
        }

        $pemeliharaans = $query->latest()->paginate(15);
        $kategoris = Kategori::where('user_id', auth()->id())->get();

        return view('pemeliharaans.index', compact('pemeliharaans', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::where('user_id', auth()->id())->get();
        return view('pemeliharaans.create', compact('kategoris'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nup_bmn' => 'nullable|string|max:255',
            'nama_barang' => 'nullable|string|max:255',
            'merk_type' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'rincian_pekerjaan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'pagu' => 'required|numeric|min:0'
        ]);

        $validated['user_id'] = auth()->id();
        Pemeliharaan::create($validated);

        return redirect()->route('pemeliharaans.index', ['kategori_id' => $validated['kategori_id']])
            ->with('success', 'Data pemeliharaan berhasil ditambahkan!');
    }

    public function show(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pemeliharaans.show', compact('pemeliharaan'));
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) {
            abort(403);
        }

        $kategoris = Kategori::where('user_id', auth()->id())->get();
        return view('pemeliharaans.edit', compact('pemeliharaan', 'kategoris'));
    }

    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nup_bmn' => 'nullable|string|max:255',
            'nama_barang' => 'nullable|string|max:255',
            'merk_type' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'rincian_pekerjaan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'pagu' => 'required|numeric|min:0'
        ]);

        $pemeliharaan->update($validated);

        return redirect()->route('pemeliharaans.index', ['kategori_id' => $validated['kategori_id']])
                        ->with('success', 'Data pemeliharaan berhasil diupdate!');
    }

    public function destroy(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) {
            abort(403);
        }

        $kategoriId = $pemeliharaan->kategori_id;
        $pemeliharaan->delete();

        return redirect()->route('pemeliharaans.index', ['kategori_id' => $kategoriId])
                        ->with('success', 'Data pemeliharaan berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = Pemeliharaan::where('user_id', auth()->id())->with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        } else {
            return redirect()->back()->with('error', 'Silakan pilih kategori terlebih dahulu sebelum mencetak.');
        }

        $pemeliharaans = $query->get();
        $kategori = Kategori::find($request->kategori_id);

        $totalBiaya = $pemeliharaans->sum('biaya');
        $totalPagu = $pemeliharaans->sum('pagu');
        $sisaAnggaran = $totalPagu - $totalBiaya;

        $pdf = PDF::loadView('pemeliharaans.pdf', compact('pemeliharaans', 'totalBiaya', 'totalPagu', 'sisaAnggaran', 'kategori'));
        
        return $pdf->download('kartu-kendali-' . ($kategori->nama_kategori ?? 'data') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PemeliharaanExport($request->kategori_id), 'kartu-kendali-pemeliharaan-' . date('Y-m-d') . '.xlsx');
    }
}