<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
                    </ol>
                </nav>
                <h1 class="page-title">Profil Saya</h1>
            </div>
        </div>
    </x-slot>

    <!-- User identity strip -->
    <div class="card-bps p-3 mb-4 border-start border-primary border-4">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary fs-4" style="width: 50px; height: 50px;">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-bps-blue">{{ Auth::user()->name ?? '-' }}</h5>
                <div class="text-muted small" style="font-size: 0.8rem;"><i class="bi bi-envelope me-2"></i>{{ Auth::user()->email ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Update Profile Info -->
        <div class="col-lg-6">
            <div class="card-bps h-100">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-bps-blue"><i class="bi bi-person-fill me-2"></i>Informasi Profil</h6>
                    <p class="text-muted small mb-0 mt-1" style="font-size: 0.75rem;">Perbarui nama dan alamat email akun Anda.</p>
                </div>
                <div class="p-3 p-md-4">
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success border-0 rounded-2 mb-3 small fw-bold py-2">
                            <i class="bi bi-check-circle-fill me-2"></i> Profil berhasil diperbarui.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-3 border-top mt-3">
                            <button type="submit" class="btn-bps btn-bps-primary px-4 w-100 justify-content-center">
                                <i class="bi bi-save me-2"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-lg-6">
            <div class="card-bps h-100">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-bps-blue"><i class="bi bi-shield-lock-fill me-2"></i>Ubah Password</h6>
                    <p class="text-muted small mb-0 mt-1" style="font-size: 0.75rem;">Pastikan akun Anda menggunakan password yang kuat.</p>
                </div>
                <div class="p-3 p-md-4">
                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success border-0 rounded-2 mb-3 small fw-bold py-2">
                            <i class="bi bi-check-circle-fill me-2"></i> Password berhasil diperbarui.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted mt-1" style="font-size: 0.7rem;">Minimal 8 karakter acak.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-3 border-top mt-3">
                            <button type="submit" class="btn-bps btn-bps-primary px-4 w-100 justify-content-center" style="background-color: var(--bps-orange); border-color: var(--bps-orange);">
                                <i class="bi bi-key me-2"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
