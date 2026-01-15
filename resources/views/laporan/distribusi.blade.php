<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Distribusi Aset (KIR)') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.distribusi') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Ruangan</label>
                <select name="ruangan_id"
                    class="rounded-lg border-gray-300 text-sm w-full focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Semua Ruangan --</option>
                    @foreach ($ruangans as $r)
                        <option value="{{ $r->id }}" {{ $ruanganId == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Dari</label>
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
            <a href="{{ route('laporan.distribusi') }}" class="text-gray-500 font-bold py-2 px-4 text-sm">Reset</a>

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
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Ruangan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Jml</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Tgl Distribusi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($distribusi as $d)
                    <tr>
                        <td class="px-6 py-4 text-sm font-bold">{{ $d->barang->nama_barang }} <br> <span
                                class="font-normal text-xs text-gray-500">{{ $d->barang->kode_barang }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $d->ruangan->nama_ruangan }}</td>
                        <td class="px-6 py-4 text-sm">{{ $d->jumlah }} {{ $d->barang->satuan }}</td>
                        <td class="px-6 py-4 text-sm">{{ $d->kondisi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $d->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Data kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">{{ $distribusi->links() }}</div>
    </div>
</x-app-layout>
