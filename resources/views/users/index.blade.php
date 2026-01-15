<x-app-layout>
    <x-slot name="header">
        {{ __('Manajemen Pengguna') }}
    </x-slot>

    <x-table.search-header :url="route('users.index')">
        <div>
            <h3 class="text-gray-800 font-bold text-xl">Manajemen Pengguna</h3>
            <p class="text-gray-500 text-sm">Kelola akun pegawai dan pimpinan.</p>
        </div>

        <x-slot name="filter">
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Role / Jabatan</label>
                <select name="role"
                    class="w-full text-xs rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Role</option>
                    <option value="Pegawai" {{ request('role') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                    <option value="Pimpinan" {{ request('role') == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                </select>
            </div>
        </x-slot>
    </x-table.search-header>

    <div class="mb-4 text-right">
        <a href="{{ route('users.create') }}"
            class="inline-flex bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Pengguna
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">No
                        </th>

                        <x-table.sortable-th name="nama_lengkap" label="Nama Lengkap" />
                        <x-table.sortable-th name="username" label="Username" />
                        <x-table.sortable-th name="role" label="Role" />

                        <th class="px-6 py-3 text-right text-xs font-bold text-indigo-800 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3 border border-indigo-200">
                                        {{ substr($u->nama_lengkap, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $u->nama_lengkap }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $u->username }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $u->role === 'Pegawai' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('users.edit', $u->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Edit</a>
                                <x-forms.delete-button :action="route('users.destroy', $u->id)" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <p>Belum ada data pengguna.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
