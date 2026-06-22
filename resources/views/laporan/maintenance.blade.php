<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Agenda Pemeliharaan & Penyusutan') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.maintenance') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Agenda</label>
                <select name="jenis"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Gabungan (Semua)</option>
                    <option value="Servis" {{ $jenis == 'Servis' ? 'selected' : '' }}>Jadwal Servis</option>
                    <option value="Penyusutan" {{ $jenis == 'Penyusutan' ? 'selected' : '' }}>Habis Masa Penyusutan
                    </option>
                </select>
            </div>

            <div class="w-full md:w-36">
                <label class="block text-xs font-bold text-gray-700 mb-1">Bulan</label>
                <select name="bulan"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $bulan == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="w-full md:w-28">
                <label class="block text-xs font-bold text-gray-700 mb-1">Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>

            <a href="{{ route('laporan.maintenance') }}"
                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded-lg text-sm transition">
                Reset
            </a>

            <div class="flex-grow"></div>

            <button type="submit" name="download_pdf" value="1"
                class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Download PDF
            </button>
        </form>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Kode
                            Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama
                            Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Jadwal
                            Servis</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Penyusutan Habis</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $b)
                        <tr>
                            <td class="px-6 py-4 text-sm font-mono text-indigo-600 font-bold">
                                {{ $b->getRawOriginal('kode_barang') ?? $b->kode_barang }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $b->nama_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $b->kategori->nama_kategori }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($b->tgl_servis_berikutnya)
                                    <span class="text-blue-700 bg-blue-50 px-2 py-0.5 rounded font-medium">
                                        {{ \Carbon\Carbon::parse($b->tgl_servis_berikutnya)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($b->tgl_penyusutan_habis)
                                    <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium">
                                        {{ \Carbon\Carbon::parse($b->tgl_penyusutan_habis)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Tidak ada agenda aset yang
                                terjadwal pada bulan tersebut.</td>
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
