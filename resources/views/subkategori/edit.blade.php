<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Sub Kategori') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <form action="{{ route('subkategori.update', $subkategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('subkategori._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
