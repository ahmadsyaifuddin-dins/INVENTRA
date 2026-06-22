<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Statistik Kepatuhan Pegawai') }}
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('laporan.per_pegawai') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Pegawai</label>
                <select name="user_id"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Pegawai</option>
                    @foreach ($listPegawai as $lp)
                        <option value="{{ $lp->id }}" {{ $userId == $lp->id ? 'selected' : '' }}>
                            {{ $lp->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>

            <a href="{{ route('laporan.per_pegawai') }}"
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama
                            Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Username</th>
                        <th class="px-6 py-3 class="text-center" text-xs font-bold text-gray-800 uppercase
                            tracking-wider">Total Pinjam</th>
                        <th class="px-6 py-3 class="text-center" text-xs font-bold text-gray-800 uppercase
                            tracking-wider">Tepat Waktu (Kembali)</th>
                        <th class="px-6 py-3 class="text-center" text-xs font-bold text-gray-800 uppercase
                            tracking-wider">Pernah Terlambat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pegawais as $p)
                        <tr>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $p->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $p->username }}</td>
                            <td class="px-6 py-4 text-sm text-center font-semibold text-gray-700">{{ $p->total_pinjam }}
                                Kali</td>
                            <td class="px-6 py-4 text-sm text-center text-green-600 font-bold">{{ $p->total_selesai }}
                                Kali</td>
                            <td class="px-6 py-4 text-sm text-center text-red-600 font-bold">{{ $p->total_telat }} Kali
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Data pegawai tidak
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pegawais->links() }}
        </div>
    </div>
</x-app-layout>
