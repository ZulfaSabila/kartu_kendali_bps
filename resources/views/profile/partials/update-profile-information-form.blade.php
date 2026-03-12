<section>
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

        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input type="text" id="name" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}"
                       required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}"
                       required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-3 rounded-3" style="background:#fffbeb;border:1px solid #fde68a;">
                        <p class="small text-warning-emphasis mb-1">Email Anda belum diverifikasi.</p>
                        <button form="send-verification"
                                class="small text-decoration-underline border-0 bg-transparent p-0"
                                style="color:#92400e;">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 small text-success mb-0">Link verifikasi baru telah dikirim ke email Anda.</p>
                        @endif
                    </div>
                @endif
            </div>

            <button type="submit" class="btn-bps-save">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</section>