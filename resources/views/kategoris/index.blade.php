<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori — Kartu Kendali BPS Kota Bontang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── VARIABEL WARNA BPS ── */
        :root {
            --bps-blue: #003366;
            --bps-blue-dark: #002244;
            --bps-orange: #E8751A;
            --bps-green: #77B02A;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* ── HEADER & BREADCRUMB ── */
        .page-header {
            background: var(--white);
            padding: 25px 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }

        .breadcrumb {
            margin-bottom: 10px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--bps-orange);
            text-decoration: none;
        }

        .page-title {
            font-weight: 800;
            color: var(--bps-blue-dark);
            letter-spacing: -0.5px;
            margin: 0;
        }

        .btn-back {
            background-color: var(--bps-blue);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background-color: var(--bps-blue-dark);
            transform: translateX(-3px);
            color: var(--white);
        }

        /* ── TABLE STYLING ── */
        .card-table {
            background: var(--white);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f1f5f9;
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #f8fafc;
        }

        .table tbody tr:hover {
            background-color: #fcfdfe;
        }

        .kat-name {
            font-weight: 700;
            color: var(--bps-blue);
            text-decoration: none;
        }

        .kat-name:hover {
            color: var(--bps-orange);
        }

        .badge-count {
            background-color: rgba(0, 51, 102, 0.08);
            color: var(--bps-blue);
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* ── ACTION BUTTONS ── */
        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-edit {
            border-color: #fbbf24;
            color: #b45309;
            background: transparent;
        }

        .btn-edit:hover {
            background: #fbbf24;
            color: white;
        }

        .btn-delete {
            border-color: #f87171;
            color: #b91c1c;
            background: transparent;
        }

        .btn-delete:hover {
            background: #f87171;
            color: white;
        }

        /* ── ALERT SUCCESS ── */
        .alert-bps {
            border: none;
            border-left: 5px solid var(--bps-green);
            background: #f0fdf4;
            color: #166534;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 16px 20px;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: #e2e8f0;
            margin-bottom: 20px;
            display: block;
        }

        /* ── PAGINATION ── */
        .pagination-wrapper {
            padding: 25px 20px;
            border-top: 1px solid var(--border-color);
        }

        /* ── FOOTER ── */
        .footer-text {
            color: #94a3b8;
            font-size: 0.8rem;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .page-header { text-align: center; }
            .btn-back { margin-top: 15px; width: 100%; }
        }
    </style>
</head>
<body>

    {{-- ══ PAGE HEADER ══ --}}
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Kategori</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">Daftar Kategori BMN</h2>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">

        {{-- ══ ALERT SUCCESS ══ --}}
        @if(session('success'))
            <div class="alert alert-bps alert-dismissible fade show mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ══ TABLE CARD ══ --}}
        <div class="card-table">
            @if($kategoris->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-folder2-open"></i>
                    <h5 class="fw-bold">Belum Ada Data Kategori</h5>
                    <p class="text-muted">Silakan tambahkan kategori baru melalui menu dashboard.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">No</th>
                                <th>Nama Kategori</th>
                                <th class="d-none d-md-table-cell">Deskripsi</th>
                                <th class="text-center">Jumlah Barang</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $index => $kategori)
                            <tr>
                                <td class="text-center fw-bold text-muted">
                                    {{ $kategoris->firstItem() + $index }}
                                </td>
                                <td>
                                    <a href="{{ route('barangs.index', ['kategori_id' => $kategori->id]) }}" class="kat-name">
                                        {{ $kategori->nama_kategori }}
                                    </a>
                                </td>
                                <td class="d-none d-md-table-cell text-muted">
                                    {{ Str::limit($kategori->deskripsi ?? 'Tidak ada deskripsi.', 50) }}
                                </td>
                                <td class="text-center">
                                    <span class="badge-count">
                                        {{ $kategori->barangs_count ?? $kategori->barangs->count() }} Item
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('kategoris.edit', $kategori) }}" class="btn-action btn-edit" title="Edit Kategori">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua barang di dalamnya akan ikut terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus Kategori">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ══ PAGINATION ══ --}}
                @if($kategoris->hasPages())
                    <div class="pagination-wrapper bg-light">
                        <div class="d-flex justify-content-center">
                            {{ $kategoris->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            @endif
        </div>

        {{-- ══ FOOTER ══ --}}
        <p class="footer-text">
            &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>