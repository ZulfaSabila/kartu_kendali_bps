<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - BPS Kota Bontang</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bps-blue:    #003366;
            --bps-dark:    #002347;
            --bps-green:   #77B02A;
            --bps-light:   #f8fafc;
            --border-color:#e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bps-light);
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container-main { flex: 1; }
        footer { border-top: 1px solid var(--border-color); }

        /* ── Navbar ────────────────────────────────────────── */
        .navbar-bps {
            background-color: var(--bps-blue);
            border-bottom: 3px solid var(--bps-green);
        }

        /* ── Page title ─────────────────────────────────────── */
        .page-title {
            color: var(--bps-blue);
            font-weight: 700;
            border-left: 4px solid var(--bps-green);
            padding-left: 15px;
            margin: 0;
        }

        /* ── Section card ───────────────────────────────────── */
        .section-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .section-card-header {
            padding: 18px 24px 16px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
            border-left: 4px solid var(--bps-blue);
        }

        .section-card-header h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--bps-blue);
            margin: 0 0 3px;
        }

        .section-card-header p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin: 0;
        }

        .section-card-body { padding: 24px; }

        /* ── Form controls ──────────────────────────────────── */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.88rem;
            padding: 10px 14px;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: var(--bps-blue);
            box-shadow: 0 0 0 3px rgba(0,51,102,0.08);
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: 0.78rem; }

        /* ── Buttons ────────────────────────────────────────── */
        .btn-bps-save {
            background-color: var(--bps-blue);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 9px 24px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s, transform 0.15s;
            cursor: pointer;
        }
        .btn-bps-save:hover { background-color: var(--bps-dark); transform: translateY(-1px); }

        .btn-bps-danger {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 9px 24px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            cursor: pointer;
        }
        .btn-bps-danger:hover { background-color: #fee2e2; }

        /* ── Success alert ──────────────────────────────────── */
        .alert-bps-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid var(--bps-green);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #166534;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Avatar circle ──────────────────────────────────── */
        .avatar-circle {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--bps-blue), #1d4ed8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── Password strength hint ─────────────────────────── */
        .input-hint {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    {{-- ══════════════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════════════ --}}
    <nav class="navbar navbar-dark navbar-bps py-3 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="https://www.bps.go.id/_next/image?url=%2Fassets%2Flogo-bps.png&w=1080&q=75"
                     alt="Logo BPS" width="40" class="me-2">
                KARTU KENDALI
            </a>

            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle border-0"
                        type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ Auth::user()->name ?? 'User' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door-fill me-2 text-muted"></i>Dashboard
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════ --}}
    <div class="container container-main pb-5">

        {{-- Page Header --}}
        <div class="d-flex align-items-center mb-4">
            <h1 class="h4 page-title">Profil Saya</h1>
        </div>

        {{-- User identity strip --}}
        <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-white rounded-3 border"
             style="border-color:var(--border-color)!important;">
            <div class="avatar-circle">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <div class="fw-bold" style="color:var(--bps-dark);font-size:1rem;">
                    {{ Auth::user()->name ?? '-' }}
                </div>
                <div class="text-muted" style="font-size:0.82rem;">
                    {{ Auth::user()->email ?? '-' }}
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- ── (1) Update Profile Info ── --}}
            <div class="col-lg-6">
                <div class="section-card h-100">
                    <div class="section-card-header">
                        <h5><i class="bi bi-person-fill me-2"></i>Informasi Profil</h5>
                        <p>Perbarui nama dan alamat email akun Anda.</p>
                    </div>
                    <div class="section-card-body">

                        @if(session('status') === 'profile-updated')
                            <div class="alert-bps-success mb-4">
                                <i class="bi bi-check-circle-fill"></i> Profil berhasil diperbarui.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', Auth::user()->name) }}"
                                       required autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', Auth::user()->email) }}"
                                       required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-bps-save">
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── (2) Update Password ── --}}
            <div class="col-lg-6">
                <div class="section-card h-100">
                    <div class="section-card-header">
                        <h5><i class="bi bi-shield-lock-fill me-2"></i>Ubah Password</h5>
                        <p>Gunakan password yang panjang dan acak agar akun tetap aman.</p>
                    </div>
                    <div class="section-card-body">

                        @if(session('status') === 'password-updated')
                            <div class="alert-bps-success mb-4">
                                <i class="bi bi-check-circle-fill"></i> Password berhasil diperbarui.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       autocomplete="current-password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="input-hint">Minimal 8 karakter.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-bps-save">
                                <i class="bi bi-lock-fill"></i> Simpan Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── (3) Hapus Akun ── --}}
            <div class="col-12">
                <div class="section-card">
                    <div class="section-card-header" style="border-left-color: #ef4444;">
                        <h5 style="color:#dc2626;"><i class="bi bi-exclamation-triangle-fill me-2"></i>Hapus Akun</h5>
                        <p>Setelah akun dihapus, semua data akan dihapus secara permanen.</p>
                    </div>
                    <div class="section-card-body">
                        <p class="text-muted small mb-3">
                            Pastikan Anda telah mengunduh semua data sebelum menghapus akun.
                            Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                        </p>

                        <button type="button" class="btn-bps-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash3-fill"></i> Hapus Akun Saya
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Konfirmasi Hapus Akun --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Akun
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted small mb-3">
                        Setelah akun dihapus, semua data terkait akan hilang selamanya.
                        Masukkan password Anda untuk mengonfirmasi.
                    </p>
                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   placeholder="Masukkan password Anda">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-bps-danger">
                        <i class="bi bi-trash3-fill"></i> Ya, Hapus Akun
                    </button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    <footer class="bg-white py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted small mb-0">
                &copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bontang</strong>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Buka modal otomatis jika ada error password deletion --}}
    @if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
        });
    </script>
    @endif
</body>
</html>