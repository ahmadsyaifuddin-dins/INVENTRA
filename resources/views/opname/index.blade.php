<x-app-layout>
    <x-slot name="header">{{ __('Riwayat Pemeriksaan Aset') }}</x-slot>

    @can('manage-barang')
        <div class="mb-6 text-right">
            <a href="{{ route('opname.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                + Mulai Periksa Aset
            </a>
        </div>
    @endcan

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase">Ruangan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase">Petugas</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-indigo-800 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($opnames as $op)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($op->tanggal_opname)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold">{{ $op->ruangan->nama_ruangan }}</td>
                        <td class="px-6 py-4 text-sm">{{ $op->user->nama_lengkap }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('opname.show', $op->id) }}"
                                class="text-indigo-600 hover:text-indigo-900 font-bold">Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
