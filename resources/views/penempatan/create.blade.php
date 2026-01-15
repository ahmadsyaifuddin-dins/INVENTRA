<x-app-layout>
    <x-slot name="header">
        {{ __('Distribusi Aset Baru') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Form Penempatan Aset
            </h2>

            <form action="{{ route('penempatan.store') }}" method="POST">
                @csrf
                @include('penempatan._form')
            </form>
        </div>
    </div>
</x-app-layout>
