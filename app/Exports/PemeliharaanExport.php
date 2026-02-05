<?php

namespace App\Exports;

use App\Models\Pemeliharaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemeliharaanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $kategori_id;

    public function __construct($kategori_id = null)
    {
        $this->kategori_id = $kategori_id;
    }

    public function collection()
    {
        $query = Pemeliharaan::where('user_id', auth()->id())
                            ->with('kategori');

        if ($this->kategori_id) {
            $query->where('kategori_id', $this->kategori_id);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'NUP BMN',
            'Nama Barang',
            'Merk/Type',
            'Lokasi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Rincian Pekerjaan',
            'Biaya (Rp)',
            'Biaya Kumulatif (Rp)',
            'Pagu (Rp)',
            'Sisa Anggaran (Rp)'
        ];
    }

    public function map($pemeliharaan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $pemeliharaan->kategori->nama_kategori,
            $pemeliharaan->nup_bmn,
            $pemeliharaan->nama_barang,
            $pemeliharaan->merk_type,
            $pemeliharaan->lokasi,
            $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('d/m/Y') : '-',
            $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('d/m/Y') : '-',
            $pemeliharaan->rincian_pekerjaan,
            number_format($pemeliharaan->biaya, 0, ',', '.'),
            number_format($pemeliharaan->biaya_kumulatif, 0, ',', '.'),
            number_format($pemeliharaan->pagu, 0, ',', '.'),
            number_format($pemeliharaan->sisa_anggaran, 0, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}