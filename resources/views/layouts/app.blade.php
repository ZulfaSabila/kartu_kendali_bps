<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Badan Pusat Statistik') }}</title>

    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bps.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS for BPS Branding -->
    <style>
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
            --transition: all 0.2s ease-in-out;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Page Content ── */
        main {
            flex: 1;
            padding-bottom: 3rem;
        }

        /* ── Common Components ── */
        .card-bps {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            transition: var(--transition);
        }

        .page-header {
            background: var(--white);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--bps-blue-dark);
            letter-spacing: -0.5px;
            margin: 0;
            border-left: 4px solid var(--bps-green);
            padding-left: 1rem;
        }

        /* ── Buttons ── */
        .btn-bps {
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
        }

        .btn-bps-primary {
            background-color: var(--bps-blue);
            color: var(--white);
            border: none;
        }

        .btn-bps-primary:hover {
            background-color: var(--bps-blue-dark);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 51, 102, 0.2);
        }

        .btn-bps-orange {
            background-color: var(--bps-orange);
            color: var(--white);
            border: none;
        }

        .btn-bps-orange:hover {
            background-color: #d16614;
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(232, 117, 26, 0.2);
        }

        .btn-bps-outline {
            background-color: transparent;
            color: var(--bps-blue);
            border: 2px solid var(--bps-blue);
        }

        .btn-bps-outline:hover {
            background-color: var(--bps-blue);
            color: var(--white);
        }

        /* ── Tables ── */
        .table-responsive-bps {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .table-bps {
            border: 1px solid var(--border-color);
            border-collapse: collapse;
        }

        .table-bps thead th {
            background-color: #f1f5f9;
            color: #003366;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            text-align: center;
        }

        .table-bps tbody td {
            padding: 10px 12px;
            vertical-align: middle;
            font-size: 0.8rem;
            border: 1px solid var(--border-color);
        }

        .table-bps tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .table-bps tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* ── Forms ── */
        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--bps-blue-dark);
            margin-bottom: 0.35rem;
        }

        .form-control, .form-select {
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
        }

        /* ── Badges ── */
        .badge-bps {
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.7rem;
        }

        .badge-bps-blue { background-color: rgba(0, 51, 102, 0.1); color: var(--bps-blue); }
        .badge-bps-green { background-color: rgba(119, 176, 42, 0.1); color: var(--bps-green); }
        .badge-bps-orange { background-color: rgba(232, 117, 26, 0.1); color: var(--bps-orange); }

        /* ── Footer ── */
        footer {
            background: var(--white);
            padding: 2rem 0;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
        }

        .footer-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin: 0;
        }

        .footer-accents { display: flex; gap: 4px; justify-content: center; margin-top: 1rem; }
        .footer-accents span { width: 40px; height: 4px; border-radius: 2px; }
    </style>
</head>

<body>
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <div class="page-header">
            <div class="container">
                {{ $header }}
            </div>
        </div>
    @endisset

    <!-- Page Content -->
    <main>
        <div class="container mt-3">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="footer-text">
                &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
            </p>
            <div class="footer-accents">
                <span style="background: var(--bps-blue);"></span>
                <span style="background: var(--bps-orange);"></span>
                <span style="background: var(--bps-green);"></span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
