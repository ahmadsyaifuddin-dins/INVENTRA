<div class="space-y-6">
    <x-forms.dropdown name="kategori_id" label="Pilih Kategori Induk" :options="$kategoris" :selected="$subkategori->kategori_id"
        placeholder="-- Pilih Kategori --" required="true" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-forms.input name="kode_sub" label="Kode Sub Kategori" :value="$subkategori->kode_sub" placeholder="Cth: 01, 02, atau LPT"
                required="true" />
            <p class="text-xs text-gray-500 mt-1">Kode ini akan digunakan untuk merakit kode barang otomatis (Maksimal
                10 karakter).</p>
        </div>

        <div>
            <x-forms.input name="nama_sub" label="Nama Sub Kategori" :value="$subkategori->nama_sub"
                placeholder="Cth: Laptop, Printer, Meja" required="true" />
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
    <a href="{{ route('subkategori.index') }}"
        class="text-gray-500 hover:text-gray-700 mr-4 text-sm font-medium">Batal</a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $subkategori->exists ? 'Update Data' : 'Simpan Data' }}
    </button>
</div>
