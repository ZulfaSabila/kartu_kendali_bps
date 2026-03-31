<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6b7280;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pemeliharaans.index', ['barang_id' => $pemeliharaan->barang_id]) }}" class="text-decoration-none" style="color: #6b7280;">Riwayat</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #003366;">Edit Riwayat</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0" style="color: #003366;">Ubah Informasi Pemeliharaan</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pemeliharaans.update', $pemeliharaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Asset Selection Section (Admin only can change) -->
                        @if(auth()->user()->isAdmin())
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Kategori Aset</label>
                                <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ $pemeliharaan->barang->kategori_id == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Nama Barang / NUP</label>
                                <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                                    <option value="{{ $pemeliharaan->barang_id }}" selected>
                                        {{ $pemeliharaan->barang->nup_bmn }} - {{ $pemeliharaan->barang->nama_barang }}
                                    </option>
                                </select>
                                <small class="text-muted">Mengubah kategori akan memuat ulang daftar barang.</small>
                            </div>
                        </div>
                        @endif

                        <!-- Asset Info Display -->
                        <div id="asset_info_display" class="card border-0 rounded-2 p-2 mb-3" style="background-color: #F0F4FF; border-left: 4px solid #003366 !important;">
                            <div class="row g-2 text-center">
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">NUP BMN</div>
                                    <div id="info_nup" class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->nup_bmn }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">Nama Aset</div>
                                    <div id="info_nama" class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->nama_barang }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">Merk/Type</div>
                                    <div id="info_merk" class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->merk_type ?? '-' }}</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-muted small fw-bold uppercase" style="font-size: 0.6rem; color: #003366;">Lokasi</div>
                                    <div id="info_lokasi" class="fw-bold" style="font-size: 0.75rem; color: #003366;">{{ $pemeliharaan->barang->lokasi ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Detail & Budget Section -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $pemeliharaan->tanggal_mulai?->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $pemeliharaan->tanggal_selesai?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: #003366;">Rincian Perbaikan / Pemeliharaan</label>
                                <textarea name="rincian_pekerjaan" class="form-control @error('rincian_pekerjaan') is-invalid @enderror" rows="4" placeholder="Jelaskan rincian pekerjaan pemeliharaan yang dilakukan secara mendetail..." required>{{ old('rincian_pekerjaan', $pemeliharaan->rincian_pekerjaan) }}</textarea>
                                @error('rincian_pekerjaan')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Biaya (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="color: #003366;">Rp</span>
                                    <input type="text" id="biaya_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="biaya" name="biaya" value="{{ $pemeliharaan->biaya }}">
                                @error('biaya')
                                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003366;">Pagu (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="color: #003366;">Rp</span>
                                    <input type="text" id="pagu_display" class="form-control" placeholder="0" value="{{ number_format($pemeliharaan->pagu ?? $pemeliharaan->barang->pagu_anggaran, 0, ',', '.') }}">
                                </div>
                                <input type="hidden" id="pagu" name="pagu" value="{{ $pemeliharaan->pagu ?? $pemeliharaan->barang->pagu_anggaran }}">
                                <small class="text-muted">Pagu dapat disesuaikan per transaksi pemeliharaan.</small>
                                @error('pagu')
                                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pemeliharaans.index', ['barang_id' => $pemeliharaan->barang_id]) }}" class="btn-bps btn-bps-outline px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="btn-bps btn-bps-primary px-4 py-2">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const kategoriSelect = document.getElementById('kategori_id');
        const barangSelect = document.getElementById('barang_id');
        const infoDisplay = document.getElementById('asset_info_display');
        const initialBarangId = "{{ $pemeliharaan->barang_id }}";

        if (kategoriSelect) {
            kategoriSelect.addEventListener('change', function () {
                const kategoriId = this.value;
                barangSelect.innerHTML = '<option value="">Memuat data...</option>';
                barangSelect.disabled = true;
                infoDisplay.style.display = 'none';
                if (!kategoriId) return;

                fetch(`/api/barangs-by-kategori/${kategoriId}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    barangSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';
                    let foundMatch = false;
                    
                    data.forEach(barang => {
                        const opt = document.createElement('option');
                        opt.value = barang.id;
                        opt.textContent = `${barang.nup_bmn} - ${barang.nama_barang}`;
                        opt.dataset.nup = barang.nup_bmn || '-';
                        opt.dataset.nama = barang.nama_barang || '-';
                        opt.dataset.merk = barang.merk_type || '-';
                        opt.dataset.lokasi = barang.lokasi || '-';
                        opt.dataset.pagu = barang.pagu_anggaran || 0;
                        
                        if (barang.id == initialBarangId) {
                            opt.selected = true;
                            foundMatch = true;
                        }
                        
                        barangSelect.appendChild(opt);
                    });
                    
                    barangSelect.disabled = false;
                    if (foundMatch) {
                        barangSelect.dispatchEvent(new Event('change'));
                    }
                })
                .catch(error => {
                    barangSelect.innerHTML = '<option value="">Gagal memuat data. Silakan refresh halaman.</option>';
                    barangSelect.disabled = true;
                    console.error('AJAX Error:', error);
                });
            });
        }

        if (barangSelect) {
            barangSelect.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                if (!selected || !selected.value) { 
                    infoDisplay.style.display = 'none'; 
                    return; 
                }
                
                document.getElementById('info_nup').innerText = selected.dataset.nup || '-';
                document.getElementById('info_nama').innerText = selected.dataset.nama || '-';
                document.getElementById('info_merk').innerText = selected.dataset.merk || '-';
                document.getElementById('info_lokasi').innerText = selected.dataset.lokasi || '-';
                infoDisplay.style.display = 'block';

                // Auto-fill Pagu field if it exists (for create/edit consistency)
                const paguRaw = selected.dataset.pagu;
                const paguHidden = document.getElementById('pagu');
                const paguDisplay = document.getElementById('pagu_display');
                if (paguHidden && paguDisplay && paguRaw) {
                    paguHidden.value = paguRaw;
                    paguDisplay.value = new Intl.NumberFormat('id-ID').format(paguRaw);
                }
            });
        }

        function setupCurrencyMask(displayId, hiddenId) {
            const display = document.getElementById(displayId);
            const hidden = document.getElementById(hiddenId);
            if (!display || !hidden) return;
            display.addEventListener('input', function () {
                const raw = this.value.replace(/\D/g, '');
                display.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                hidden.value = raw || 0;
            });
        }
        setupCurrencyMask('biaya_display', 'biaya');
        setupCurrencyMask('pagu_display', 'pagu');
    </script>
</x-app-layout>
