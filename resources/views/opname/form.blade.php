<x-app-layout>
    <x-slot name="header">{{ __('Lembar Kerja Stock Opname') }}</x-slot>

    <form action="{{ route('opname.store') }}" method="POST">
        @csrf
        <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="bg-indigo-50 p-4 rounded-lg mb-6 border border-indigo-100 flex justify-between items-center">
            <div>
                <p class="text-sm text-indigo-600 uppercase tracking-wide font-bold">Lokasi Pemeriksaan</p>
                <h2 class="text-2xl font-bold text-indigo-900">{{ $ruangan->nama_ruangan }}</h2>
            </div>
            <div class="text-right">
                <p class="text-sm text-indigo-600 uppercase tracking-wide font-bold">Tanggal</p>
                <p class="text-lg font-bold text-indigo-900">{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Barang / Aset</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-800 uppercase">Jml Sistem</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-800 uppercase">Jml Fisik</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Status Fisik</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dataBarang as $d)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $d->barang->nama_barang }}</div>
                                <div class="text-xs text-gray-500">{{ $d->barang->kode_barang }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $d->jumlah }}
                                </span>
                                <input type="hidden" name="details[{{ $d->barang_id }}][jumlah_sistem]"
                                    value="{{ $d->jumlah }}">
                            </td>

                            <td class="px-6 py-4 text-center">
                                <input type="number" name="details[{{ $d->barang_id }}][jumlah_fisik]"
                                    value="{{ $d->jumlah }}"
                                    class="w-20 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="details[{{ $d->barang_id }}][status]"
                                            value="Ada" checked
                                            class="text-green-600 border-gray-300 focus:ring-green-500">
                                        <span class="ml-2 text-sm text-gray-700">Ada / Sesuai</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="details[{{ $d->barang_id }}][status]"
                                            value="Rusak"
                                            class="text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                        <span class="ml-2 text-sm text-gray-700">Rusak</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="details[{{ $d->barang_id }}][status]"
                                            value="Hilang" class="text-red-600 border-gray-300 focus:ring-red-500">
                                        <span class="ml-2 text-sm text-gray-700">Hilang</span>
                                    </label>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <input type="text" name="details[{{ $d->barang_id }}][ket]"
                                    placeholder="Keterangan..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                Tidak ada barang tercatat di ruangan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Kesimpulan (Opsional)</label>
            <textarea name="catatan_umum" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('opname.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded-lg">Batal</a>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">Simpan Hasil
                Opname</button>
        </div>
    </form>
</x-app-layout>
