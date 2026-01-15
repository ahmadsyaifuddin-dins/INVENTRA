<x-app-layout>
    <x-slot name="header">{{ __('Laporan Aset per Kategori') }}</x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.per_kategori') }}" method="GET"
            class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id" class="rounded-lg border-gray-300 text-sm w-full">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->id }}" {{ $kategoriId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tgl Input Dari</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="rounded-lg border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Sampai</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="rounded-lg border-gray-300 text-sm">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm">Filter</button>
            <a href="{{ route('laporan.per_kategori') }}" class="text-gray-500 font-bold py-2 px-4 text-sm">Reset</a>

            <div class="flex-grow"></div>

            <button type="submit" name="download_pdf" value="1"
                class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-lg text-sm flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> PDF
            </button>
        </form>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Nama Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Merek</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Tahun</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($barangs as $b)
                    <tr>
                        <td class="px-6 py-4 text-sm font-bold text-indigo-700">{{ $b->kategori->nama_kategori }}</td>
                        <td class="px-6 py-4 text-sm">{{ $b->nama_barang }} <br><small
                                class="text-gray-500">{{ $b->kode_barang }}</small></td>
                        <td class="px-6 py-4 text-sm">{{ $b->merek ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $b->tahun_perolehan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Data kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">{{ $barangs->links() }}</div>
    </div>
</x-app-layout>
