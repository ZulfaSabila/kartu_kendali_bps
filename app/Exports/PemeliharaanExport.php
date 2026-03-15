<?php

namespace App\Exports;

use App\Models\Pemeliharaan;
use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PemeliharaanExport implements FromQuery, ShouldAutoSize, WithStyles, WithColumnFormatting, WithHeadings, WithMapping, WithEvents
{
    protected $barangId;
    protected $search;
    protected $rowNumber = 0;

    public function __construct($barangId = null, $search = null)
    {
        $this->barangId = $barangId;
        $this->search = $search;
    }

    public function query()
    {
        $query = Pemeliharaan::with('barang');

        if ($this->barangId) {
            $query->where('barang_id', $this->barangId);
        }

        if ($this->search) {
            $query->where('rincian_pekerjaan', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy('tanggal_mulai', 'asc');
    }

    public function headings(): array
    {
        return [
            ['KARTU KENDALI PEMELIHARAAN BARANG MILIK NEGARA'],
            ['BPS Kota Bontang'],
            [''],
            ['No', 'Tanggal Mulai', 'Tanggal Selesai', 'Rincian Pekerjaan', 'Biaya (Rp)', 'Biaya Kumulatif (Rp)', 'Pagu (Rp)', 'Sisa Anggaran (Rp)']
        ];
    }

    public function map($p): array
    {
        $this->rowNumber++;
        $pagu_anggaran = $p->barang->pagu_anggaran ?? $p->pagu;
        $sisaAnggaran = $pagu_anggaran - $p->biaya_kumulatif_dinamis;

        return [
            $this->rowNumber,
            $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-',
            $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-',
            $p->rincian_pekerjaan,
            (float)$p->biaya,
            (float)$p->biaya_kumulatif_dinamis,
            (float)$pagu_anggaran,
            (float)$sisaAnggaran,
        ];
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
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        
        return [
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            2 => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A4:H' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
