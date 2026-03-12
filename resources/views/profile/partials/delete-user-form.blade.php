<section>
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
</section>

{{-- Modal Konfirmasi Hapus Akun --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1"
     @if($errors->userDeletion->isNotEmpty()) aria-hidden="false" @endif>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Akun
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="modal-body pt-2">
                    <p class="text-muted small mb-3">
                        Semua data terkait akun Anda akan hilang selamanya.
                        Masukkan password Anda untuk mengonfirmasi penghapusan.
                    </p>

                    <div>
                        <label class="form-label" for="delete_password">Password</label>
                        <input type="password" id="delete_password" name="password"
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="Masukkan password Anda">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn-bps-danger">
                        <i class="bi bi-trash3-fill"></i> Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Buka modal otomatis jika ada error validasi --}}
@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
    });
</script>
@endif