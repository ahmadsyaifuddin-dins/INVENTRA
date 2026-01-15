<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <x-forms.input name="nama_ruangan" label="Nama Ruangan" :value="$ruangan->nama_ruangan"
        placeholder="Cth: Ruang Tata Usaha, Gudang A, Lab Komputer" required="true" />

    <x-forms.input name="penanggung_jawab" label="Penanggung Jawab (PIC)" :value="$ruangan->penanggung_jawab"
        placeholder="Nama pegawai yang bertanggung jawab" required="true" />
</div>

<div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
    <a href="{{ route('ruangan.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm font-medium">
        Batal
    </a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $ruangan->exists ? 'Update Ruangan' : 'Simpan Ruangan' }}
    </button>
</div>
