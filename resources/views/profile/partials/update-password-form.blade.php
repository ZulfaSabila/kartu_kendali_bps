<section>
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
                <label class="form-label" for="update_password_current_password">Password Saat Ini</label>
                <input type="password" id="update_password_current_password"
                       name="current_password"
                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                       autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="update_password_password">Password Baru</label>
                <input type="password" id="update_password_password"
                       name="password"
                       class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                       autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="input-hint">Minimal 8 karakter.</div>
            </div>

            <div class="mb-4">
                <label class="form-label" for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="update_password_password_confirmation"
                       name="password_confirmation"
                       class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                       autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-bps-save">
                <i class="bi bi-lock-fill"></i> Simpan Password
            </button>
        </form>
    </div>
</section>