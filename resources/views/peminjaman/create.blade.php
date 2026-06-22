<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'Administrator' ? __('Catat Peminjaman Aset') : __('Ajukan Peminjaman Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                {{-- Header Form --}}
                <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50">
                    <h3 class="text-lg font-bold text-indigo-900">Formulir Peminjaman Baru</h3>
                    <p class="text-indigo-700 text-sm mt-1">
                        Silakan lengkapi data peminjaman di bawah ini.
                        {{ auth()->user()->role === 'Pegawai' ? 'Pengajuan Anda akan ditinjau dan diproses oleh Administrator.' : '' }}
                    </p>
                </div>

                <div class="p-6">
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        @include('peminjaman._form')
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
