<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BPS KOTA BONTANG TAHUN 2026</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 10px; margin: 0; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 14px; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .info-table td { border: none; padding: 3px 5px; font-size: 11px; }
        .main-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 6px 4px; word-wrap: break-word; }
        .main-table th { background-color: #f2f2f2; text-transform: uppercase; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary-box { margin-top: 20px; float: right; width: 300px; border: 1px solid #000; padding: 10px; }
        .footer-note { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KARTU KENDALI</h2>
        <div style="font-size: 12px; margin-top: 5px;">BPS KOTA BONTANG {{ date('Y') }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">NUP BMN</td><td width="2%">:</td><td width="33%"><strong>{{ $pemeliharaans->first()->nup_bmn ?? '-' }}</strong></td>
            <td width="15%">Merk/Type</td><td width="2%">:</td><td width="33%">{{ $pemeliharaans->first()->merk_type ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Barang</td><td>:</td><td>{{ $pemeliharaans->first()->nama_barang ?? '-' }}</td>
            <td>Lokasi</td><td>:</td><td>Bontang</td>
        </tr>
    </table>

    <table class="main-table">
    <thead>
        <tr>
            <th width="3%" class="text-center">No</th>
            <th width="10%">Tanggal Mulai Pekerjaan</th>
            <th width="10%">Tanggal Selesai Pekerjaan</th>
            <th width="27%">Rincian Pekerjaan</th>
            <th width="12%" class="text-right">Biaya (Rp)</th>
            <th width="12%" class="text-right">Biaya Kumulatif (Rp)</th>
            <th width="12%" class="text-right">Pagu (Rp)</th>
            <th width="12%" class="text-right">Sisa (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pemeliharaans as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->rincian_pekerjaan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->pagu, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->pagu - $item->biaya, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="summary-box">
    <table style="width: 100%; border: none;">
        <tr><td style="border:none">TOTAL REALISASI BIAYA</td><td style="border:none" class="text-right"><strong>Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong></td></tr>
        <tr><td style="border:none">TOTAL PAGU ANGGARAN</td><td style="border:none" class="text-right"><strong>Rp {{ number_format($totalPagu, 0, ',', '.') }}</strong></td></tr>
        <tr><td style="border:none; border-top: 1px solid #000; padding-top: 5px;">SISA ANGGARAN</td><td style="border:none; border-top: 1px solid #000; padding-top: 5px;" class="text-right"><strong>Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</strong></td></tr>
    </table>
</div>

    <div class="footer-note">
        <p>Bontang, {{ date('d F Y') }}</p>
        <p style="margin-top: 60px;">( ............................................ )</p>
    </div>
</body>
</html>