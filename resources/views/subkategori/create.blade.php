<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Sub Kategori') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <form action="{{ route('subkategori.store') }}" method="POST">
                    @csrf
                    @include('subkategori._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
