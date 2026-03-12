<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $kategori->nama_kategori }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('kategoris.edit', $kategori) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Edit Kategori
                </a>
                <a href="{{ route('pemeliharaans.create') }}?kategori_id={{ $kategori->id }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    + Tambah Pemeliharaan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Kategori -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-2">Deskripsi</h3>
                    <p class="text-gray-600">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Total Pagu</div>
                        <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPagu, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Total Biaya</div>
                        <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Sisa Anggaran</div>
                        <div class="text-2xl font-bold {{ $sisaAnggaran >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pemeliharaan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Data Pemeliharaan</h3>
                    
                    @if($pemeliharaans->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rincian Pekerjaan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biaya (Rp)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pagu (Rp)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sisa Anggaran (Rp)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pemeliharaans as $index => $pemeliharaan)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">{{ $pemeliharaans->firstItem() + $index }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">{{ $pemeliharaan->tanggal_mulai ? $pemeliharaan->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">{{ $pemeliharaan->tanggal_selesai ? $pemeliharaan->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                            <td class="px-4 py-4 text-sm">{{ Str::limit($pemeliharaan->rincian_pekerjaan, 30) }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">{{ number_format($pemeliharaan->biaya, 0, ',', '.') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">{{ number_format($pemeliharaan->pagu, 0, ',', '.') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm {{ $pemeliharaan->sisa_anggaran >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($pemeliharaan->sisa_anggaran, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('pemeliharaans.show', $pemeliharaan) }}" class="text-blue-600 hover:text-blue-900 mr-2">Detail</a>
                                                <a href="{{ route('pemeliharaans.edit', $pemeliharaan) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                                <form action="{{ route('pemeliharaans.destroy', $pemeliharaan) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus data ini? Tindakan tidak dapat dibatalkan.')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $pemeliharaans->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600">Belum ada data pemeliharaan.</p>
                            <a href="{{ route('pemeliharaans.create') }}?kategori_id={{ $kategori->id }}" class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                + Tambah Pemeliharaan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>