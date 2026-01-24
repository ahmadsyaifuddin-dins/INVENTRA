<x-app-layout>
    <x-slot name="header">{{ __('Detail Hasil Pemeriksaan Aset') }}</x-slot>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Laporan Ruangan: <span class="text-indigo-600">{{ $opname->ruangan->nama_ruangan }}</span>
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                <i class="far fa-calendar-alt mr-1"></i> Tanggal Cek:
                {{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d F Y') }}
                <span class="mx-2">•</span>
                <i class="far fa-user mr-1"></i> Pemeriksa: {{ $opname->user->nama_lengkap }}
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('opname.index') }}"
                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 rounded-lg shadow-sm transition">
                &larr; Kembali
            </a>

            <a href="{{ route('opname.print', $opname->id) }}"
                class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Cetak Berita Acara
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase">Barang / Aset</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-indigo-900 uppercase">Jml Sistem</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-indigo-900 uppercase">Jml Fisik</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-indigo-900 uppercase">Selisih</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($opname->details as $d)
                        @php
                            $selisih = $d->jumlah_fisik - $d->jumlah_sistem;
                            // Warna baris: Merah muda kalau ada masalah (Hilang/Rusak/Selisih minus)
                            $rowClass = $d->status_fisik != 'Ada' || $selisih < 0 ? 'bg-red-50' : 'hover:bg-gray-50';
                        @endphp
                        <tr class="{{ $rowClass }} transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $d->barang->nama_barang }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $d->barang->kode_barang }}</div>
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-gray-600 font-medium">
                                {{ $d->jumlah_sistem }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-900 font-bold">
                                {{ $d->jumlah_fisik }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($selisih == 0)
                                    <span class="text-gray-400">-</span>
                                @elseif($selisih < 0)
                                    <span class="text-red-600 font-bold">{{ $selisih }}</span>
                                @else
                                    <span class="text-blue-600 font-bold">+{{ $selisih }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($d->status_fisik == 'Ada')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sesuai / Ada
                                    </span>
                                @elseif($d->status_fisik == 'Rusak')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Rusak
                                    </span>
                                @elseif($d->status_fisik == 'Hilang')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Hilang
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $d->status_fisik }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 italic">
                                {{ $d->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">Tidak ada detail barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Catatan Pemeriksa / Kesimpulan</h3>
        <div class="p-4 bg-gray-50 rounded-lg text-gray-700 text-sm border border-gray-200 min-h-[80px]">
            {{ $opname->catatan ?? 'Tidak ada catatan tambahan.' }}
        </div>
    </div>

</x-app-layout>
