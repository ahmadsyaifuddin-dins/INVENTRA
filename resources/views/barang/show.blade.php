<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                {{-- Header Card --}}
                <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-indigo-900">Informasi Aset</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-200 text-indigo-800">
                        {{ $barang->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        {{-- Kolom Kiri: Foto --}}
                        <div class="md:col-span-1">
                            @if ($barang->foto)
                                <img src="{{ asset('uploads/barang/' . $barang->foto) }}"
                                    alt="{{ $barang->nama_barang }}"
                                    class="w-full h-auto rounded-lg shadow-md object-cover border-4 border-white ring-1 ring-gray-200">
                            @else
                                <div
                                    class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-xs">Tidak ada foto</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Kolom Kanan: Detail Data --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $barang->nama_barang }}</h1>
                                <p class="text-sm text-gray-500">Kode Aset: <span
                                        class="font-mono font-bold text-indigo-600">{{ $barang->kode_barang }}</span>
                                </p>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Merek / Brand</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $barang->merek ?? '-' }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Tahun Perolehan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $barang->tahun_perolehan }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Satuan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $barang->satuan }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Input</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $barang->created_at->format('d M Y') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center gap-3 mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('barang.index') }}"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                                    &larr; Kembali
                                </a>

                                @can('manage-barang')
                                    <a href="{{ route('barang.edit', $barang->id) }}"
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                        Edit Data
                                    </a>
                                @endcan
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
