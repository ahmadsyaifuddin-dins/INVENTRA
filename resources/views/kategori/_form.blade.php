<x-forms.input name="kode_kategori" label="Kode Kategori" :value="$kategori->kode_kategori" placeholder="Contoh: ELK, MBL, KDR"
    required="true" maxlength="10" />

<x-forms.input name="nama_kategori" label="Nama Kategori" :value="$kategori->nama_kategori" placeholder="Contoh: Elektronik Kantor"
    required="true" />

<x-forms.textarea name="deskripsi" label="Deskripsi (Opsional)" :value="$kategori->deskripsi"
    placeholder="Penjelasan singkat tentang kategori ini..." />

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('kategori.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm">
        Batal
    </a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $kategori->exists ? 'Update Kategori' : 'Simpan Kategori' }}
    </button>
</div>
