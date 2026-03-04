<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PemeliharaanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    // Konstruktor menerima data dari Controller
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    // Header kolom sesuai gambar excel yang Anda kirim
    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'NUP BMN',
            'Nama Barang',
            'Merk/Typ',
            'Lokasi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Rincian Pekerjaan',
            'Biaya (Rp)',
            'Biaya Kumulatif (Rp)',
            'Pagu (Rp)',
            'Sisa Anggaran (Rp)',
        ];
    }

    // Mapping data per kolom agar tidak kosong
    public function map($p): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $p->barang->kategori->nama_kategori ?? '-',
            $p->barang->nup_bmn ?? '-',
            $p->barang->nama_barang ?? '-',
            $p->barang->merk_type ?? '-',
            $p->barang->lokasi ?? '-',
            $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-',
            $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-',
            $p->rincian_pekerjaan,
            $p->biaya,
            $p->biaya_kumulatif,
            $p->pagu,
            ($p->pagu - $p->biaya_kumulatif),
        ];
    }
}