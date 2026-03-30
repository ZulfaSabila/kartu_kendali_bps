<?php

namespace App\Exports;

use App\Models\Pemeliharaan;
use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
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

class PemeliharaanExport implements FromQuery, WithColumnWidths, WithStyles, WithColumnFormatting, WithHeadings, WithMapping, WithEvents
{
    protected $barangId;
    protected $search;
    protected $barang;
    protected $rowNumber = 0;

    public function __construct($barangId = null, $search = null)
    {
        $this->barangId = $barangId;
        $this->search = $search;
        if ($barangId) {
            $this->barang = Barang::find($barangId);
        }
    }

    public function query()
    {
        $query = Pemeliharaan::with('barang')
            ->whereHas('barang', function($q) {
                $q->whereNull('deleted_at')
                  ->whereHas('kategori', function($kq) {
                      $kq->whereNull('deleted_at');
                  });
            });

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
        $headings = [
            ['KARTU KENDALI PEMELIHARAAN BARANG MILIK NEGARA'],
            ['BPS Kota Bontang'],
            [''],
        ];

        if ($this->barang) {
            $headings[] = ['NUP BMN', ': ' . ($this->barang->nup_bmn ?? '-')];
            $headings[] = ['Nama Barang', ': ' . $this->barang->nama_barang];
            $headings[] = ['Merk/Type', ': ' . ($this->barang->merk_type ?? '-')];
            $headings[] = ['Lokasi', ': ' . ($this->barang->lokasi ?? 'Bontang')];
            $headings[] = [''];
        }

        $headings[] = ['No', 'Tanggal Mulai', 'Tanggal Selesai', 'Rincian Pekerjaan', 'Biaya (Rp)', 'Biaya Kumulatif (Rp)', 'Pagu (Rp)', 'Sisa Anggaran (Rp)'];

        return $headings;
    }

    public function map($p): array
    {
        $this->rowNumber++;
        // Gunakan pagu dari baris riwayat masing-masing
        $currentPagu = $p->pagu;
        $sisaAnggaran = $currentPagu - $p->biaya_kumulatif_dinamis;

        return [
            $this->rowNumber,
            $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-',
            $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-',
            $p->rincian_pekerjaan,
            (float)$p->biaya,
            (float)$p->biaya_kumulatif_dinamis,
            (float)$currentPagu,
            (float)$sisaAnggaran,
        ];
    }

    public function columnFormats(): array
    {
        // Menggunakan format mata uang Rupiah secara otomatis di Excel
        return [
            'E' => '"Rp "#,##0', // Biaya
            'F' => '"Rp "#,##0', // Biaya Kumulatif
            'G' => '"Rp "#,##0', // Pagu
            'H' => '"Rp "#,##0', // Sisa Anggaran
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 13,
            'B' => 15,
            'C' => 15,
            'D' => 30,
            'E' => 18,
            'F' => 22,
            'G' => 18,
            'H' => 22,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        
        $headerRow = $this->barang ? 9 : 4;

        return [
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            2 => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            $headerRow => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $headerRow = $this->barang ? 9 : 4;
                $startDataRow = $headerRow + 1;

                // Merge cells for titles, details, and summary
                $event->sheet->getDelegate()->mergeCells('A1:H1');
                $event->sheet->getDelegate()->mergeCells('A2:H2');
                if ($this->barang) {
                    $event->sheet->getDelegate()->mergeCells('B4:H4');
                    $event->sheet->getDelegate()->mergeCells('B5:H5');
                    $event->sheet->getDelegate()->mergeCells('B6:H6');
                    $event->sheet->getDelegate()->mergeCells('B7:H7');
                }
                $event->sheet->getDelegate()->mergeCells('F' . ($lastRow + 2) . ':G' . ($lastRow + 2));
                $event->sheet->getDelegate()->mergeCells('F' . ($lastRow + 3) . ':G' . ($lastRow + 3));
                $event->sheet->getDelegate()->mergeCells('F' . ($lastRow + 4) . ':G' . ($lastRow + 4));
                
                
                // Border untuk seluruh tabel
                $event->sheet->getStyle('A' . $headerRow . ':H' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Rata tengah untuk semua kolom kecuali D (Rincian Pekerjaan)
                $event->sheet->getStyle('A' . $startDataRow . ':C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('E' . $startDataRow . ':H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                // Khusus No (Kolom A) rata tengah
                $event->sheet->getStyle('A' . $headerRow . ':A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Tambahkan Summary Section di akhir Excel
                $summaryRow = $lastRow + 2;
                
                // Ambil data terbaru untuk Pagu
                $query = $this->query();
                $allData = $query->get();
                $totalBiaya = $allData->sum('biaya');
                $latestItem = $allData->last(); // Karena di query sudah orderBy tanggal_mulai asc
                $activePagu = $latestItem && $latestItem->pagu ? $latestItem->pagu : ($this->barang->pagu_anggaran ?? 0);
                
                $sheet = $event->sheet->getDelegate();
                
                // Total Realisasi
                $sheet->setCellValue('F' . $summaryRow, 'TOTAL REALISASI PEMELIHARAAN');
                $sheet->setCellValue('H' . $summaryRow, $totalBiaya);
                $sheet->getStyle('F' . $summaryRow . ':H' . $summaryRow)->getFont()->setBold(true);
                $sheet->getStyle('H' . $summaryRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');

                // Total Pagu Terbaru
                $sheet->setCellValue('F' . ($summaryRow + 1), 'TOTAL PAGU ANGGARAN (Terbaru)');
                $sheet->setCellValue('H' . ($summaryRow + 1), $activePagu);
                $sheet->getStyle('F' . ($summaryRow + 1) . ':H' . ($summaryRow + 1))->getFont()->setBold(true);
                $sheet->getStyle('H' . ($summaryRow + 1))->getNumberFormat()->setFormatCode('"Rp "#,##0');

                // Garis pembatas double
                $sheet->getStyle('F' . ($summaryRow + 2) . ':H' . ($summaryRow + 2))->getBorders()->getTop()->setBorderStyle(Border::BORDER_DOUBLE);

                // Sisa Anggaran Saat Ini
                $sheet->setCellValue('F' . ($summaryRow + 2), 'SISA ANGGARAN SAAT INI');
                $sheet->setCellValue('H' . ($summaryRow + 2), $activePagu - $totalBiaya);
                $sheet->getStyle('F' . ($summaryRow + 2) . ':H' . ($summaryRow + 2))->getFont()->setBold(true)->setSize(11);
                $sheet->getStyle('H' . ($summaryRow + 2))->getNumberFormat()->setFormatCode('"Rp "#,##0');
                
                $sheet->getStyle('F' . $summaryRow . ':F' . ($summaryRow + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('H' . $summaryRow . ':H' . ($summaryRow + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
