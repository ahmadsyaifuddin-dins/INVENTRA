<x-app-layout>
    <x-slot name="header">
        {{ __('Data Induk Barang') }}
    </x-slot>

    <x-table.search-header :url="route('barang.index')">
        <div>
            <h3 class="text-gray-800 font-bold text-xl">Daftar Aset</h3>
            <p class="text-gray-500 text-sm">Semua barang yang terdaftar di sistem inventaris.</p>
        </div>

        <x-slot name="filter">
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id"
                    class="w-full text-xs rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Tahun Perolehan</label>
                <input type="number" name="tahun_perolehan" value="{{ request('tahun_perolehan') }}"
                    class="w-full text-xs rounded-md border-gray-300 focus:border-indigo-500" placeholder="Cth: 2023">
            </div>
        </x-slot>
    </x-table.search-header>

    @can('manage-barang')
        <div class="mb-4 text-right">
            <a href="{{ route('barang.create') }}"
                class="inline-flex bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Barang
            </a>
        </div>
    @endcan

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <x-table.sortable-th name="nama_barang" label="Info Produk" />
                        <x-table.sortable-th name="merek" label="Merek" />
                        <x-table.sortable-th name="tahun_perolehan" label="Tahun" />

                        @can('manage-barang')
                            <th class="px-6 py-3 text-right text-xs font-bold text-indigo-800 uppercase tracking-wider">
                                Aksi
                            </th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $b)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if ($b->foto)
                                            <img class="h-12 w-12 rounded-lg object-cover border border-gray-200"
                                                src="{{ asset('uploads/barang/' . $b->foto) }}" alt="">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
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
                                        <div class="text-sm font-bold text-gray-900">{{ $b->nama_barang }}</div>
                                        <div
                                            class="text-xs text-gray-500 font-mono bg-gray-100 px-1 py-0.5 rounded inline-block mt-1">
                                            {{ $b->kode_barang }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mb-1">
                                    {{ $b->kategori->nama_kategori }}
                                </span>
                                <div class="text-sm text-gray-500">{{ $b->merek ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $b->tahun_perolehan }}</div>
                                <div class="text-xs text-gray-500">{{ $b->satuan }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                @can('manage-barang')
                                    <a href="{{ route('barang.edit', $b->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit
                                    </a>
                                @endcan
                                @can('manage-master')
                                    <x-forms.delete-button :action="route('barang.destroy', $b->id)" />
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p>Tidak ada data yang cocok dengan filter/pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $barangs->links() }}
        </div>
    </div>
</x-app-layout>
