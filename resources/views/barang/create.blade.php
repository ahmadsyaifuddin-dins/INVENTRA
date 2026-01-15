<x-app-layout>
    <x-slot name="header">
        {{ __('Input Barang Baru') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Form Input Barang
            </h2>

            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('barang._form')
            </form>
        </div>
    </div>
</x-app-layout>
