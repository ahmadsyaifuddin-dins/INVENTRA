<x-forms.input name="nama_lengkap" label="Nama Lengkap" :value="$user->nama_lengkap" placeholder="Contoh: Budi Santoso"
    required="true" />

<x-forms.input name="username" label="Username" :value="$user->username" placeholder="Username untuk login" required="true" />

<x-forms.input type="password" name="password" label="Password"
    placeholder="{{ $user->exists ? 'Kosongkan jika tidak ingin mengganti password' : 'Minimal 6 karakter' }}"
    :required="!$user->exists" />

{{-- UPDATE DROPDOWN ROLE --}}
<x-forms.dropdown name="role" label="Role / Hak Akses" :options="[
    'Administrator' => 'Administrator (Super Admin)',
    'Pegawai' => 'Pegawai (Tata Usaha)',
    'Gudang' => 'Gudang (Lapangan)',
    'Pimpinan' => 'Pimpinan (Read Only)',
]" :selected="$user->role" required="true" />

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm">
        Batal
    </a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $user->exists ? 'Update Pengguna' : 'Simpan Pengguna' }}
    </button>
</div>
