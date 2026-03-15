<?php

namespace App\Exports;

use App\Models\Pemeliharaan;
use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PemeliharaanExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $barangId;
    protected $search;

    public function __construct($barangId = null, $search = null)
    {
        $this->barangId = $barangId;
        $this->search = $search;
    }

    public function view(): View
    {
        $query = Pemeliharaan::query();

        if ($this->barangId) {
            $query->where('barang_id', $this->barangId);
        }

        if ($this->search) {
            $query->where('rincian_pekerjaan', 'like', '%' . $this->search . '%');
        }

        $pemeliharaans = $query->orderBy('tanggal_mulai', 'asc')->get();
        
        // Jika barangId tidak ada di request, coba ambil dari record pertama
        $barang = null;
        if ($this->barangId) {
            $barang = Barang::find($this->barangId);
        } elseif ($pemeliharaans->count() > 0) {
            $barang = $pemeliharaans->first()->barang;
        }

        return view('exports.pemeliharaan', compact('pemeliharaans', 'barang'));
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0', // Biaya
            'F' => '#,##0', // Biaya Kumulatif
            'G' => '#,##0', // Pagu
            'H' => '#,##0', // Sisa Anggaran
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // No specific style needed as View handles it, 
            // but we can add more if necessary here.
        ];
    }
}
