<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemeliharaanExport;

class PemeliharaanController extends Controller
{
    /**
     * Menampilkan daftar pemeliharaan dengan filter barang spesifik.
     */
    public function index(Request $request)
    {
        $query = Pemeliharaan::where('user_id', auth()->id())->with('barang.kategori');

        // Filter berdasarkan kategori jika ada
        if ($request->filled('kategori_id')) {
            $query->whereHas('barang', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        // PERBAIKAN: Filter ketat berdasarkan barang_id agar data tidak bercampur
        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('barang', function($bq) use ($search) {
                    $bq->where('nup_bmn', 'like', "%{$search}%")
                       ->orWhere('nama_barang', 'like', "%{$search}%");
                })->orWhere('rincian_pekerjaan', 'like', "%{$search}%");
            });
        }

        // Urutan kronologis (Lama ke Baru) sesuai gambar Kartu Kendali
        $pemeliharaans = $query->orderBy('tanggal_mulai', 'asc')->paginate(20);
        
        // Mengambil data barang yang sedang dipilih untuk informasi di header
        $selectedBarang = null;
        if ($request->filled('barang_id')) {
            $selectedBarang = Barang::with('kategori')->find($request->barang_id);
        }

        return view('pemeliharaans.index', compact('pemeliharaans', 'selectedBarang'));
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
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'rincian_pekerjaan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'pagu' => 'required|numeric|min:0',
            'biaya_kumulatif' => 'required|numeric|min:0'
        ]);

        $validated['user_id'] = auth()->id();
        Pemeliharaan::create($validated);

        return redirect()->route('pemeliharaans.index', ['barang_id' => $request->barang_id])->with('success', 'Data pemeliharaan berhasil ditambahkan!');
        }

    public function show(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) abort(403);
        $pemeliharaan->load('barang.kategori');
        return view('pemeliharaans.show', compact('pemeliharaan'));
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) abort(403);
        $kategoris = Kategori::where('user_id', auth()->id())->get();
        $pemeliharaan->load('barang');
        return view('pemeliharaans.edit', compact('pemeliharaan', 'kategoris'));
    }

    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'rincian_pekerjaan' => 'nullable|string',
            'pagu' => 'required|numeric|min:0',
            'biaya' => 'required|numeric|min:0',
            'biaya_kumulatif' => 'required|numeric|min:0'
        ]);

        $pemeliharaan->update($validated);

        return redirect()->route('pemeliharaans.index', ['barang_id' => $pemeliharaan->barang_id])
                        ->with('success', 'Data pemeliharaan berhasil diperbarui!');
    }

    public function destroy(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->user_id !== auth()->id()) abort(403);
        $barangId = $pemeliharaan->barang_id;
        $pemeliharaan->delete();
        return redirect()->route('pemeliharaans.index', ['barang_id' => $barangId])
                        ->with('success', 'Data pemeliharaan berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = Pemeliharaan::where('user_id', auth()->id())->with('barang.kategori');
        
        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        $pemeliharaans = $query->orderBy('tanggal_mulai', 'asc')->get();
        $groupedData = $pemeliharaans->groupBy('barang_id');

        $pdf = Pdf::loadView('pemeliharaans.pdf', compact('groupedData'))->setPaper('a4', 'landscape');
        return $pdf->download('kartu-kendali-' . date('Y-m-d') . '.pdf');
    }
            }