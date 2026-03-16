<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Kelola Pegawai</li>
                    </ol>
                </nav>
                <h1 class="page-title" style="color: #003366;">Kelola Pegawai</h1>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <button type="button" class="btn-bps btn-bps-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                    <i class="bi bi-person-plus"></i> Tambah Pegawai
                </button>
            </div>
        </div>
    </x-slot>

    <div class="card-bps mt-2">
        <div class="table-responsive">
            <table class="table table-bps table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">NO</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center" style="width: 150px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffUsers as $index => $staff)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $staff->name }}</div>
                        </td>
                        <td>{{ $staff->email }}</td>
                        <td class="text-center">
                            @if($staff->is_active)
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">Aktif</span>
                            @else
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('users.toggle-active', $staff->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    @if($staff->is_active)
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3" onclick="return confirm('Nonaktifkan akun pegawai ini?')">
                                            <i class="bi bi-person-x"></i> Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-success px-3" onclick="return confirm('Aktifkan kembali akun pegawai ini?')">
                                            <i class="bi bi-person-check"></i> Aktifkan
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="addStaffModalLabel">Tambah Pegawai Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold" style="color: #003366;">NAMA LENGKAP</label>
                            <input type="text" name="name" id="name" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold" style="color: #003366;">EMAIL INSTANSI</label>
                            <input type="email" name="email" id="email" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="contoh@bps.go.id" required>
                        </div>
                        <div class="mb-0">
                            <label for="password" class="form-label small fw-bold" style="color: #003366;">PASSWORD</label>
                            <input type="password" name="password" id="password" class="form-control rounded-2 shadow-none border-light-subtle" placeholder="Minimal 8 karakter" required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">Simpan Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
