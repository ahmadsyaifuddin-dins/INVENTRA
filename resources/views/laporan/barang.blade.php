<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Data Barang') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.barang') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow">
                <i class="fas fa-filter mr-2"></i> Filter Data
            </button>

            <a href="{{ route('laporan.barang') }}"
                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded-lg text-sm transition">
                Reset
            </a>

            <div class="flex-grow"></div>

            <button type="submit" name="download_pdf" value="1"
                class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Download PDF
            </button>

            <button type="button"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow flex items-center opacity-50 cursor-not-allowed"
                title="Segera Hadir">
                <i class="fas fa-file-excel mr-2"></i> Excel
            </button>
        </form>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Tanggal
                            Input</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Kode
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama
                            Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Tahun
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $b)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $b->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $b->kode_barang }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $b->nama_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $b->kategori->nama_kategori }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $b->tahun_perolehan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Data tidak ditemukan pada
                                rentang tanggal tersebut.</td>
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
