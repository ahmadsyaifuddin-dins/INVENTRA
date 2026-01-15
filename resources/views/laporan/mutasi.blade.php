<x-app-layout>
    <x-slot name="header">{{ __('Laporan Riwayat Mutasi') }}</x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.mutasi') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="rounded-lg border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="rounded-lg border-gray-300 text-sm">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm">Filter</button>
            <a href="{{ route('laporan.mutasi') }}" class="text-gray-500 font-bold py-2 px-4 text-sm">Reset</a>

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
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Waktu Transaksi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Ke Ruangan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Kondisi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mutasi as $m)
                    <tr>
                        <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $m->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold">{{ $m->barang->nama_barang }} <br><span
                                class="font-normal text-xs text-gray-500">{{ $m->barang->kode_barang }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $m->ruangan->nama_ruangan }}</td>
                        <td class="px-6 py-4 text-sm">{{ $m->jumlah }} {{ $m->barang->satuan }}</td>
                        <td class="px-6 py-4 text-sm">{{ $m->kondisi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada riwayat transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">{{ $mutasi->links() }}</div>
    </div>
</x-app-layout>
