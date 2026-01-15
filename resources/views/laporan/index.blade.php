<x-app-layout>
    <x-slot name="header">
        {{ __('Pusat Laporan') }}
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">

        <a href="{{ route('laporan.barang') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group">
            <div
                class="w-14 h-14 mx-auto bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mb-4 group-hover:bg-indigo-600 group-hover:text-white transition">
                <i class="fas fa-box fa-2x"></i>
            </div>
            <h3 class="font-bold text-gray-800">Laporan Aset</h3>
            <p class="text-xs text-gray-500 mt-2">Daftar inventaris & filter tanggal masuk.</p>
        </a>

        <a href="{{ route('laporan.distribusi') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group">
            <div
                class="w-14 h-14 mx-auto bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                <i class="fas fa-dolly fa-2x"></i>
            </div>
            <h3 class="font-bold text-gray-800">Distribusi Ruangan</h3>
            <p class="text-xs text-gray-500 mt-2">Kartu Inventaris Ruangan (KIR).</p>
        </a>

        <a href="{{ route('laporan.kondisi') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group">
            <div
                class="w-14 h-14 mx-auto bg-rose-100 rounded-full flex items-center justify-center text-rose-600 mb-4 group-hover:bg-rose-600 group-hover:text-white transition">
                <i class="fas fa-heart-broken fa-2x"></i>
            </div>
            <h3 class="font-bold text-gray-800">Kondisi Aset</h3>
            <p class="text-xs text-gray-500 mt-2">Rekap barang baik & rusak.</p>
        </a>

        <a href="{{ route('laporan.mutasi') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group">
            <div
                class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-history fa-2x"></i>
            </div>
            <h3 class="font-bold text-gray-800">Riwayat Mutasi</h3>
            <p class="text-xs text-gray-500 mt-2">Log pergerakan barang (Masuk/Keluar).</p>
        </a>

        <a href="{{ route('laporan.per_kategori') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group">
            <div
                class="w-14 h-14 mx-auto bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                <i class="fas fa-tags fa-2x"></i>
            </div>
            <h3 class="font-bold text-gray-800">Per Kategori</h3>
            <p class="text-xs text-gray-500 mt-2">Laporan pengelompokan jenis aset.</p>
        </a>

    </div>
</x-app-layout>
