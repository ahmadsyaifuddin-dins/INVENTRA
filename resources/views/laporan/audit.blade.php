<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Hasil Audit & Ringkasan Stok Opname') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.audit') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-700 mb-1">Dari Tanggal Audit</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-700 mb-1">Sampai Tanggal Audit</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow">
                <i class="fas fa-filter mr-2"></i> Filter Audit
            </button>

            <a href="{{ route('laporan.audit') }}"
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Tanggal
                            Audit</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama
                            Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Stok
                            Sistem</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Stok
                            Fisik</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Selisih
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Keterangan Kondisi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($audits as $a)
                        @php
                            $sistem = $a->jumlah_sistem ?? 0;
                            $fisik = $a->jumlah_fisik ?? 0;
                            $selisih = $fisik - $sistem;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            {{-- PENGAMAN RELASI OPNAME (TANGGAL) --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if ($a->opname)
                                    {{ \Carbon\Carbon::parse($a->opname->created_at)->format('d/m/Y') }}
                                @else
                                    <span class="text-red-500 font-medium italic">Data Induk Hilang</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($a->barang)
                                    <div class="text-sm font-bold text-gray-800">{{ $a->barang->nama_barang }}</div>
                                    <div
                                        class="text-xs text-gray-500 font-mono bg-gray-100 px-1 py-0.5 rounded inline-block mt-1">
                                        {{ $a->barang->kode_barang }}
                                    </div>
                                @else
                                    <div class="text-sm font-bold text-red-500 italic">Aset Telah Dihapus</div>
                                    <div class="text-xs text-gray-400 mt-1">Data master tidak ditemukan</div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $sistem }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $fisik }}</td>
                            <td class="px-6 py-4 text-sm font-bold">
                                @if ($selisih == 0)
                                    <span class="text-green-600">Sesuai (0)</span>
                                @else
                                    <span class="text-red-600">Selisih ({{ $selisih }})</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 italic">
                                {{ $a->keterangan ?? 'Tidak ada catatan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Data hasil pemeriksaan fisik (Opname) tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $audits->links() }}
        </div>
    </div>
</x-app-layout>
