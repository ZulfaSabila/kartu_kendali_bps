<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Kendali Pemeliharaan BPS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 12px;
            font-weight: normal;
        }
        .info-section {
            margin-bottom: 15px;
            font-size: 11px;
        }
        .info-section table {
            width: 100%;
            border: none;
        }
        .info-section td {
            border: none;
            padding: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .summary table {
            border: none;
        }
        .summary td {
            border: none;
            padding: 5px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>KARTU KENDALI PEMELIHARAAN</h2>
        <h3>BPS KOTA BONTANG TAHUN {{ date('Y') }}</h3>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td width="50%"><strong>NUP BMN:</strong> {{ $pemeliharaans->first()->nup_bmn ?? '-' }}</td>
                <td width="50%"><strong>Merk/Type:</strong> {{ $pemeliharaans->first()->merk_type ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Nama Barang:</strong> {{ $pemeliharaans->first()->nama_barang ?? '-' }}</td>
                <td><strong>Lokasi:</strong> Bontang</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%" class="text-center">No</th>
                <th width="10%">Tanggal Mulai Pekerjaan</th>
                <th width="10%">Tanggal Selesai Pekerjaan</th>
                <th width="18%">Rincian Pekerjaan</th>
                <th width="10%" class="text-right">Biaya (Rp)</th>
                <th width="10%" class="text-right">Biaya Kumulatif (Rp)</th>
                <th width="10%" class="text-right">Pagu (Rp)</th>
                <th width="15%" class="text-right">Sisa Anggaran (Rp) = (6) - (7)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeliharaans as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->rincian_pekerjaan ?? '-' }}</td>
                    <td class="text-right">{{ number_format($item->biaya, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->biaya, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->pagu, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->pagu - $item->biaya, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td width="70%" class="font-bold">TOTAL BIAYA:</td>
                <td width="30%" class="text-right font-bold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">TOTAL PAGU:</td>
                <td class="text-right font-bold">Rp {{ number_format($totalPagu, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">SISA ANGGARAN:</td>
                <td class="text-right font-bold" style="color: {{ $sisaAnggaran >= 0 ? 'green' : 'red' }}">
                    Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 30px;">
        <p>Lokasi: Bontang</p>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>
</body>
</html>