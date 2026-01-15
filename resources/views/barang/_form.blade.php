<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-forms.input name="kode_barang" label="Kode Barang" :value="$barang->kode_barang" placeholder="Cth: 3.01.02.01"
            required="true" />

        <x-forms.input name="nama_barang" label="Nama Barang" :value="$barang->nama_barang" placeholder="Cth: Laptop ASUS ROG"
            required="true" />

        <x-forms.dropdown name="kategori_id" label="Kategori" :options="$kategoris" :selected="$barang->kategori_id"
            placeholder="-- Pilih Kategori --" required="true" />

        <x-forms.input name="merek" label="Merek / Brand" :value="$barang->merek"
            placeholder="Cth: ASUS, Samsung, Olympic" />
    </div>

    <div>
        <div class="grid grid-cols-2 gap-4">
            <x-forms.input name="tahun_perolehan" type="number" label="Tahun Perolehan" :value="$barang->tahun_perolehan ?? date('Y')"
                placeholder="YYYY" required="true" />

            <x-forms.input name="satuan" label="Satuan" :value="$barang->satuan" placeholder="Unit/Buah/Set"
                required="true" />
        </div>

        <x-forms.image-upload name="foto" label="Foto Barang (Opsional)" :value="$barang->foto" />
    </div>
</div>

<div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
    <a href="{{ route('barang.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm font-medium">
        Batal
    </a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $barang->exists ? 'Update Data Barang' : 'Simpan Data Barang' }}
    </button>
</div>
