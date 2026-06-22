<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-4">
        {{-- Dropdown Data Barang --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang <span
                    class="text-red-500">*</span></label>
            <select name="barang_id" required
                class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">-- Pilih Barang yang Tersedia --</option>
                @foreach ($barangs as $b)
                    <option value="{{ $b->id }}" {{ $peminjaman->barang_id == $b->id ? 'selected' : '' }}>
                        {{ $b->kode_barang }} - {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-forms.input type="date" name="tanggal_pinjam" label="Tanggal Pinjam" :value="$peminjaman->tanggal_pinjam"
                required="true" />
            <x-forms.input type="date" name="tanggal_kembali" label="Tanggal Kembali (Batas)" :value="$peminjaman->tanggal_kembali"
                required="true" />
        </div>
    </div>

    <div class="space-y-4">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Alasan Pinjam</label>
            <textarea name="keterangan" rows="3"
                class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                placeholder="Contoh: Digunakan untuk dinas luar kota selama 3 hari">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
        </div>

        {{-- Opsi ACC Status Hanya Muncul untuk Administrator Saat Mode Edit --}}
        @if (auth()->user()->role === 'Administrator' && $peminjaman->exists)
            <div x-data="{ statusPilih: '{{ old('status', $peminjaman->status) }}' }">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Persetujuan <span
                            class="text-red-500">*</span></label>
                    <select name="status" x-model="statusPilih" required
                        class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tampil Otomatis Kalau Status = Dikembalikan --}}
                <div x-show="statusPilih === 'Dikembalikan'" x-cloak
                    class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <label class="block text-sm font-bold text-indigo-700 mb-2">Kondisi Saat Dikembalikan <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="kondisi_kembali" value="Baik"
                                class="text-indigo-600 focus:ring-indigo-500"
                                {{ old('kondisi_kembali', $peminjaman->kondisi_kembali) === 'Baik' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Baik</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="kondisi_kembali" value="Rusak Ringan"
                                class="text-yellow-600 focus:ring-yellow-500"
                                {{ old('kondisi_kembali', $peminjaman->kondisi_kembali) === 'Rusak Ringan' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Rusak Ringan</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="kondisi_kembali" value="Rusak Berat"
                                class="text-red-600 focus:ring-red-500"
                                {{ old('kondisi_kembali', $peminjaman->kondisi_kembali) === 'Rusak Berat' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Rusak Berat</span>
                        </label>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
    <a href="{{ route('peminjaman.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm font-medium">
        Batal
    </a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $peminjaman->exists ? 'Simpan Pembaruan' : 'Ajukan Peminjaman' }}
    </button>
</div>
