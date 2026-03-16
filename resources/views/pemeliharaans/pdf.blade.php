<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Kendali Pemeliharaan - BPS Kota Bontang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10pt; padding: 20px 30px; line-height: 1.4; }
        
        .header {
            margin-bottom: 15px;
            padding-bottom: 5px;
        }
        
        .kop-table { width: 100%; border-collapse: collapse; border: none; }
        .kop-table td { border: none; vertical-align: middle; padding: 0; }
        .logo-bps { width: 90px; text-align: left; }
        .kop-text { text-align: left; padding-left: 10px; }
        .kop-text h1 { font-size: 18pt; font-weight: bold; font-style: italic; margin-bottom: -5px; color: #000; }
        .kop-text h2 { font-size: 18pt; font-weight: bold; margin-bottom: 2px; color: #000; }
        .kop-text p { font-size: 8.5pt; color: #000; line-height: 1.2; margin-top: 2px; }
        .kop-text a { color: blue; text-decoration: underline; }
        
        .thick-line { border-bottom: 3px solid #000; margin-top: 2px; }
        
        .info-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .info-table td { padding: 3px 5px; font-size: 10pt; color: #333; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed; }
        .main-table thead { display: table-header-group; }
        .main-table th { background-color: #003366; color: white; padding: 8px 4px; border: 1px solid #ccc; text-transform: uppercase; font-size: 9pt; font-weight: bold; }
        .main-table tr { page-break-inside: avoid; }
        .main-table td { padding: 6px 5px; border: 1px solid #ccc; vertical-align: middle; word-wrap: break-word; font-size: 9pt; color: #333; }
        
        .summary-container { 
            width: 100%; 
            margin-top: 15px; 
            page-break-inside: avoid; 
        }
        
        .summary-table { 
            width: 400px; 
            margin-left: auto; 
            border-collapse: collapse; 
        }
        
        .summary-table td {
            padding: 6px 8px;
            font-size: 10pt;
            font-weight: bold;
            color: #333;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-light { background-color: #fcfcfc; }
    </style>
</head>
<body>

    @php
        // Ambil data pemeliharaan untuk barang ini
        $items = $groupedData[$barang->id] ?? collect([]);
        $totalBiaya = $items->sum('biaya');
        
        // Sisa anggaran dihitung dari PAGU transaksi terakhir (terbaru)
        $latestItem = $items->sortByDesc('tanggal_mulai')->sortByDesc('id')->first();
        $activePagu = $latestItem && $latestItem->pagu ? $latestItem->pagu : ($barang->pagu_anggaran ?? 0);
        $sisaAnggaranTotal = $activePagu - $totalBiaya;
    @endphp

    <div class="header">
        <table class="kop-table">
            <tr>
                <td class="logo-bps">
                    <img src="{{ public_path('images/logo-bps.png') }}" style="width: 90px;">
                </td>
                <td class="kop-text">
                    <h1>BADAN PUSAT STATISTIK</h1>
                    <h2>KOTA BONTANG</h2>
                    <p>Jl. Awang Long No 2, Bontang Baru, Kec. Bontang Utara, Kota Bontang,<br>
                    Telp (0548) 26066  Homepage: <a href="https://bontangkota.bps.go.id/">https://bontangkota.bps.go.id/</a>  E-mail: <a href="mailto:bps6474@bps.go.id">bps6474@bps.go.id</a></p>
                </td>
            </tr>
        </table>
        <div class="thick-line"></div>
    </div>

    <div class="doc-title" style="text-align: center; margin-top: 15px; margin-bottom: 20px;">
        <h3 style="font-size: 12pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">KARTU KENDALI PEMELIHARAAN BMN</h3>
        <p style="font-size: 10pt; margin-top: 2px;">Tahun Anggaran: {{ date('Y') }}</p>
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
                <th width="11%">BIAYA KUMULATIF (Rp)</th>
                <th width="11%">PAGU (Rp)</th>
                <th width="11%">SISA ANGGARAN(Rp)</th>
            </tr>
        </thead>
        <tbody>
            @if($items->isEmpty() || $items->count() == 0)
                <tr>
                    <td colspan="8" class="text-center bg-light" style="font-style: italic; color: #666; padding: 20px;">
                        Belum ada data pemeliharaan
                    </td>
                </tr>
            @else
                @foreach($items as $index => $p)
                        @php
                            $currentPagu = $p->pagu ?? $totalPagu;
                            $sisaAnggaran = $currentPagu - $p->biaya_kumulatif_dinamis;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                            <td class="text-center">{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                            <td>{{ $p->rincian_pekerjaan }}</td>
                            <td class="text-right">{{ number_format($p->biaya, 0, ',', '.') }}</td>
                            <td class="text-right bg-light">{{ number_format($p->biaya_kumulatif_dinamis, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($currentPagu, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($sisaAnggaran, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
            @endif
        </tbody>
    </table>

    <div class="summary-container">
        <table class="summary-table">
            @if($totalBiaya == 0 && $activePagu == 0)
                <tr>
                    <td colspan="2" class="text-center" style="padding: 10px; font-style: italic; color: #666; border: 1px dashed #ddd;">
                        Belum ada realisasi anggaran
                    </td>
                </tr>
            @else
                <tr>
                    <td>TOTAL REALISASI PEMELIHARAAN</td>
                    <td class="text-right">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td>TOTAL PAGU ANGGARAN (Terbaru)</td>
                    <td class="text-right">
                        Rp {{ number_format($activePagu, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 3px double #333; padding: 0;"></td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px;">SISA ANGGARAN SAAT INI</td>
                    <td class="text-right" style="padding: 10px 8px;">
                        Rp {{ number_format($sisaAnggaranTotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </table>
    </div>

</body>
</html>