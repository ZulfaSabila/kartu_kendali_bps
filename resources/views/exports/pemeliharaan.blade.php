<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 14pt;">KARTU KENDALI PEMELIHARAAN BARANG MILIK NEGARA</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 12pt;">BPS Kota Bontang</th>
        </tr>
        <tr><th colspan="8"></th></tr>
        @if($barang)
        <tr>
            <th colspan="2" style="font-weight: bold;">NUP BMN</th>
            <th colspan="6">: {{ $barang->nup_bmn }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Nama Barang</th>
            <th colspan="6">: {{ $barang->nama_barang }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Merk / Type</th>
            <th colspan="6">: {{ $barang->merk_type ?? '-' }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Lokasi Unit</th>
            <th colspan="6">: {{ $barang->lokasi ?? '-' }}</th>
        </tr>
        @endif
        <tr><th colspan="8"></th></tr>
        <tr style="background-color: #f2f2f2;">
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Tanggal Mulai</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Tanggal Selesai</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Rincian Pekerjaan</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Biaya (Rp)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Biaya Kumulatif (Rp)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Pagu (Rp)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Sisa Anggaran (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pemeliharaans as $index => $p)
        @php
            $pagu_anggaran = $p->barang->pagu_anggaran ?? $p->pagu;
            $sisaAnggaran = $pagu_anggaran - $p->biaya_kumulatif;
        @endphp
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}</td>
            <td style="border: 1px solid #000000;">{{ $p->rincian_pekerjaan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ (float)$p->biaya }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ (float)$p->biaya_kumulatif }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ (float)$pagu_anggaran }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ (float)$sisaAnggaran }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
