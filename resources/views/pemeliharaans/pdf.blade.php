<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Kendali Pemeliharaan - BPS Kota Bontang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; padding: 30px; }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #003366;
        }
        
        .header h1 { font-size: 16px; font-weight: bold; color: #003366; margin-bottom: 3px; }
        .header h2 { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        
        .info-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .info-table td { padding: 3px 5px; font-size: 10px; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .main-table th { background-color: #003366; color: white; padding: 8px 5px; border: 1px solid #ddd; text-transform: uppercase; font-size: 8px; }
        .main-table td { padding: 8px 5px; border: 1px solid #ddd; vertical-align: middle; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-light { background-color: #f9f9f9; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    @foreach($groupedData as $barangId => $items)
        @php
            $barang = $items->first()->barang;
            $totalBiaya = $items->sum('biaya');
            $totalPagu = $items->last()->pagu ?? 0;
            $biayaKumulatif = 0;
        @endphp

        <div class="header">
            <h1>BADAN PUSAT STATISTIK KOTA BONTANG</h1>
            <h2>KARTU KENDALI PEMELIHARAAN</h2>
            <p>Tahun Anggaran: {{ date('Y') }}</p>
        </div>

        <table class="info-table">
            <tr>
                <td width="15%">NUP BMN</td><td width="35%">: <strong>{{ $barang->nup_bmn }}</strong></td>
                <td width="15%">Nama Barang</td><td width="35%">: <strong>{{ $barang->nama_barang }}</strong></td>
            </tr>
            <tr>
                <td>Merk/Type</td><td>: {{ $barang->merk_type ?? '-' }}</td>
                <td>Lokasi</td><td>: {{ $barang->lokasi ?? 'Kantor BPS' }}</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th width="4%">NO</th>
                    <th width="12%">TANGGAL MULAI PEKERJAAN</th>
                    <th width="12%">TANGGAL SELESAI PEKERJAAN</th>
                    <th width="14%">RINCIAN PEKERJAAN</th>
                    <th width="11%">BIAYA (Rp)</th>
                    <th width="11%">KUMULATIF (Rp)</th>
                    <th width="11%">PAGU (Rp)</th>
                    <th width="11%">SISA (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $p)
                    @php
                        $biayaKumulatif += $p->biaya;
                        $sisaAnggaran = $p->pagu - $biayaKumulatif;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                        <td class="text-center">{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                        <td>{{ $p->rincian_pekerjaan }}</td>
                        <td class="text-right">{{ number_format($p->biaya, 0, ',', '.') }}</td>
                        <td class="text-right bg-light">{{ number_format($biayaKumulatif, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($p->pagu, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($sisaAnggaran, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="width: 100%; margin-top: 20px;">
            <table style="width: 350px; margin-left: auto; border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px; font-size: 10px; font-weight: bold;">TOTAL REALISASI PEMELIHARAAN</td>
                    <td style="padding: 5px; font-size: 10px; font-weight: bold; text-align: right;">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; font-size: 10px; font-weight: bold;">TOTAL PAGU ANGGARAN</td>
                    <td style="padding: 5px; font-size: 10px; font-weight: bold; text-align: right;">
                        Rp {{ number_format($totalPagu, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 3px double #333; padding: 0;"></td>
                </tr>
                <tr>
                    <td style="padding: 8px 5px; font-size: 11px; font-weight: bold;">SISA ANGGARAN SAAT INI</td>
                    <td style="padding: 8px 5px; font-size: 11px; font-weight: bold; text-align: right;">
                        Rp {{ number_format($totalPagu - $totalBiaya, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>