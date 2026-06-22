<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Peminjaman Aktif & Keterlambatan') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.peminjaman') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-gray-700 mb-1">Filter Status</label>
                <select name="status"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Peminjaman Aktif</option>
                    <option value="Dipinjam" {{ $statusFilter == 'Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam
                    </option>
                    <option value="Terlambat" {{ $statusFilter == 'Terlambat' ? 'selected' : '' }}>Terlambat
                        Pengembalian</option>
                </select>
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>

            <a href="{{ route('laporan.peminjaman') }}"
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama
                            Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Batas
                            Pengembalian</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Durasi/Selisih</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjamans as $p)
                        @php
                            $tKembali = \Carbon\Carbon::parse($p->tanggal_kembali)->startOfDay();
                            $selisih = now()->startOfDay()->diffInDays($tKembali, false);
                        @endphp
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->user->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <span class="font-bold text-gray-800">{{ $p->barang->nama_barang }}</span><br>
                                <span
                                    class="text-xs font-mono bg-gray-100 px-1 rounded">{{ $p->barang->kode_barang }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $tKembali->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($selisih < 0)
                                    <span class="text-red-600 font-bold">Telat {{ abs($selisih) }} Hari</span>
                                @elseif($selisih == 0)
                                    <span class="text-amber-600 font-bold">Hari Ini</span>
                                @else
                                    <span class="text-blue-600 font-medium">{{ $selisih }} Hari Lagi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-2 py-0.5 text-xs font-bold rounded-full {{ $p->status === 'Terlambat' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Tidak ada data peminjaman
                                aktif saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-app-layout>
