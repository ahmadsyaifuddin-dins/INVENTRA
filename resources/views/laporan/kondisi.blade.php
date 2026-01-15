<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Kondisi Aset') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.kondisi') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-700 mb-1">Kondisi</label>
                <select name="kondisi" class="rounded-lg border-gray-300 text-sm w-full">
                    <option value="">-- Semua Kondisi --</option>
                    <option value="Baik" {{ $kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ $kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                    </option>
                    <option value="Rusak Berat" {{ $kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
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
            <a href="{{ route('laporan.kondisi') }}" class="text-gray-500 font-bold py-2 px-4 text-sm">Reset</a>

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
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Jml</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($dataKondisi as $d)
                    <tr>
                        <td class="px-6 py-4 text-sm font-bold">{{ $d->barang->nama_barang }}</td>
                        <td class="px-6 py-4 text-sm">{{ $d->ruangan->nama_ruangan }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs font-bold rounded-full 
                            {{ $d->kondisi == 'Baik' ? 'bg-green-100 text-green-800' : ($d->kondisi == 'Rusak Berat' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $d->kondisi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $d->jumlah }} {{ $d->barang->satuan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Data kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">{{ $dataKondisi->links() }}</div>
    </div>
</x-app-layout>
