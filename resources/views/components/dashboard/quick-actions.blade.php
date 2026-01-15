<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
        <i class="fas fa-bolt text-yellow-500"></i> Aksi Cepat
    </h3>
    <div class="space-y-3">
        <a href="{{ route('barang.create') }}"
            class="flex items-center p-3 bg-gray-50 hover:bg-indigo-50 hover:shadow-md rounded-lg transition group border border-transparent hover:border-indigo-100">
            <div
                class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition">
                <i class="fas fa-plus"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">Tambah Barang</p>
                <p class="text-xs text-gray-400">Master data baru</p>
            </div>
        </a>

        <a href="{{ route('penempatan.create') }}"
            class="flex items-center p-3 bg-gray-50 hover:bg-emerald-50 hover:shadow-md rounded-lg transition group border border-transparent hover:border-emerald-100">
            <div
                class="p-2 bg-emerald-100 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition">
                <i class="fas fa-share-square"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Distribusi Aset</p>
                <p class="text-xs text-gray-400">Mutasi ke ruangan</p>
            </div>
        </a>
    </div>
</div>
