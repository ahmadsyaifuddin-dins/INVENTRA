<x-app-layout>
    <x-slot name="header">
        {{ __('Transaksi Distribusi Aset') }}
    </x-slot>

    <x-table.search-header :url="route('penempatan.index')">
        <div>
            <h3 class="text-gray-800 font-bold text-xl">Riwayat Distribusi</h3>
            <p class="text-gray-500 text-sm">Daftar penempatan aset ke ruangan.</p>
        </div>

        <x-slot name="filter">
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Kondisi</label>
                <select name="kondisi"
                    class="w-full text-xs rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak
                        Ringan</option>
                    <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Ruangan Tujuan</label>
                <select name="ruangan_id"
                    class="w-full text-xs rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Ruangan</option>
                    @foreach ($ruangans as $r)
                        <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>
        </x-slot>
    </x-table.search-header>

    <div class="mb-4 text-right">
        <a href="{{ route('penempatan.create') }}"
            class="inline-flex bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Distribusi
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Aset
                            / Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">
                            Lokasi (Ruangan)</th>

                        <x-table.sortable-th name="jumlah" label="Jumlah" />
                        <x-table.sortable-th name="kondisi" label="Kondisi" />
                        <x-table.sortable-th name="created_at" label="Tanggal" />

                        <th class="px-6 py-3 text-right text-xs font-bold text-indigo-800 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penempatans as $index => $p)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($p->barang && $p->barang->foto)
                                            <img class="h-10 w-10 rounded-lg object-cover border border-gray-200"
                                                src="{{ asset('uploads/barang/' . $p->barang->foto) }}" alt="">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $p->barang->nama_barang ?? 'Barang Terhapus' }}</div>
                                        <div class="text-xs text-gray-500 font-mono">
                                            {{ $p->barang->kode_barang ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $p->ruangan->nama_ruangan ?? 'Ruangan Terhapus' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-bold text-gray-800">{{ $p->jumlah }}</span>
                                <span class="text-xs text-gray-500">{{ $p->barang->satuan ?? 'Unit' }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $badgeClass = match ($p->kondisi) {
                                        'Baik' => 'bg-green-100 text-green-800 border-green-200',
                                        'Rusak Ringan' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Rusak Berat' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $badgeClass }}">
                                    {{ $p->kondisi }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $p->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('penempatan.edit', $p->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Edit</a>
                                <x-forms.delete-button :action="route('penempatan.destroy', $p->id)" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <p>Belum ada data distribusi aset.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $penempatans->links() }}
        </div>
    </div>
</x-app-layout>
