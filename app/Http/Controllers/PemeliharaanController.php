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
        $query = Pemeliharaan::with('barang.kategori');

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
        $kategoris = Kategori::all();
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
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        $validated['user_id'] = auth()->id();
        Pemeliharaan::create($validated);

        return redirect()->route('pemeliharaans.index', ['barang_id' => $request->barang_id])->with('success', 'Data pemeliharaan berhasil ditambahkan!');
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        $kategoris = Kategori::all();
        $pemeliharaan->load('barang');
        return view('pemeliharaans.edit', compact('pemeliharaan', 'kategoris'));
    }

    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'rincian_pekerjaan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
        ]);

        $validated['pagu'] = $pemeliharaan->barang->pagu_anggaran;

        // Hitung ulang biaya kumulatif otomatis saat update
        $previousTotal = Pemeliharaan::where('barang_id', $pemeliharaan->barang_id)
            ->where('id', '<', $pemeliharaan->id)
            ->sum('biaya');
        $validated['biaya_kumulatif'] = $previousTotal + $request->biaya;

        $pemeliharaan->update($validated);

        // Opsi tambahan: Jika biaya di record tengah diubah, idealnya biaya_kumulatif record setelahnya juga harus diupdate.
        // Namun sesuai instruksi dasar, kita fokus pada store dan update record saat ini.
        $this->recalculateCumulativeCosts($pemeliharaan->barang_id);

        return redirect()->route('pemeliharaans.index', ['barang_id' => $pemeliharaan->barang_id])
                        ->with('success', 'Data pemeliharaan berhasil diperbarui!');
    }

    /**
     * Sinkronisasi ulang biaya kumulatif untuk satu barang jika ada perubahan di tengah data.
     */
    private function recalculateCumulativeCosts($barangId)
    {
        $records = Pemeliharaan::where('barang_id', $barangId)
            ->orderBy('tanggal_mulai', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $runningTotal = 0;
        foreach ($records as $record) {
            $runningTotal += $record->biaya;
            $record->update(['biaya_kumulatif' => $runningTotal]);
        }
    }

    public function destroy(Pemeliharaan $pemeliharaan)
    {
        $barangId = $pemeliharaan->barang_id;
        $pemeliharaan->delete();
        return redirect()->route('pemeliharaans.index', ['barang_id' => $barangId])
                        ->with('success', 'Data pemeliharaan berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = Pemeliharaan::with('barang.kategori');
        
        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        $pemeliharaans = $query->orderBy('tanggal_mulai', 'asc')->lazy();
        $groupedData = $pemeliharaans->groupBy('barang_id');

        // REQUIRED FIX: Jika barang_id ada tapi datanya kosong, tambahkan barang tersebut dengan collection kosong
        if ($request->filled('barang_id') && $groupedData->isEmpty()) {
            $barang = Barang::find($request->barang_id);
            if ($barang && $groupedData->isEmpty()) {
                $groupedData = collect([$barang->id => collect([])]);
            }
        }

        $pdf = Pdf::loadView('pemeliharaans.pdf', compact('groupedData'))->setPaper('a4', 'landscape');
        return $pdf->download('kartu-kendali-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $barangId = $request->barang_id;
        $search = $request->search;

        return Excel::download(new PemeliharaanExport($barangId, $search), 'riwayat-pemeliharaan-' . date('Y-m-d') . '.xlsx');
    }
}