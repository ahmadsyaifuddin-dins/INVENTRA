<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Kategori Barang') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Input Master Kategori</h2>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                @include('kategori._form')
            </form>
        </div>
    </div>
</x-app-layout>
