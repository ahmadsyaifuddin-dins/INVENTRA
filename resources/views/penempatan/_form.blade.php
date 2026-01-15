<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <x-forms.dropdown name="barang_id" label="Pilih Aset / Barang" :options="$barangs" :selected="$penempatan->barang_id"
        placeholder="-- Cari Kode / Nama Barang --" required="true" />

    <x-forms.dropdown name="ruangan_id" label="Lokasi Penempatan (Ruangan)" :options="$ruangans" :selected="$penempatan->ruangan_id"
        placeholder="-- Pilih Ruangan Tujuan --" required="true" />

    <x-forms.input type="number" name="jumlah" label="Jumlah Unit" :value="$penempatan->jumlah ?? 1" placeholder="1" required="true" />

    <x-forms.dropdown name="kondisi" label="Kondisi Aset" :options="['Baik' => 'Baik', 'Rusak Ringan' => 'Rusak Ringan', 'Rusak Berat' => 'Rusak Berat']" :selected="$penempatan->kondisi ?? 'Baik'" required="true" />

</div>

<div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
    <a href="{{ route('penempatan.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm font-medium">
        Batal
    </a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $penempatan->exists ? 'Update Distribusi' : 'Simpan Distribusi' }}
    </button>
</div>
