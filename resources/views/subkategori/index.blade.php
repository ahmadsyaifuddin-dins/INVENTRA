<x-app-layout>
    <x-slot name="header">
        {{ __('Data Sub Kategori') }}
    </x-slot>

    <div class="mb-4 text-right">
        <a href="{{ route('subkategori.create') }}"
            class="inline-flex bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition items-center gap-2 text-sm">
            <i class="fas fa-plus"></i> Tambah Sub Kategori
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">
                            Kategori Induk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Kode
                            Sub</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Nama
                            Sub Kategori</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-indigo-800 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subkategoris as $index => $sub)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $subkategoris->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $sub->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">
                                {{ $sub->kode_sub }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $sub->nama_sub }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('subkategori.edit', $sub->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <x-forms.delete-button :action="route('subkategori.destroy', $sub->id)" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data sub kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $subkategoris->links() }}
        </div>
    </div>
</x-app-layout>
