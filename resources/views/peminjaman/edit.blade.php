<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'Administrator' ? __('Proses Peminjaman Aset') : __('Edit Pengajuan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                {{-- Header Form & Status --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 bg-indigo-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-indigo-900">
                            {{ auth()->user()->role === 'Administrator' ? 'Verifikasi & Update Status' : 'Update Data Pengajuan' }}
                        </h3>
                        <p class="text-indigo-700 text-sm mt-1">
                            {{ auth()->user()->role === 'Administrator' ? 'Ubah status untuk menyetujui, menolak, atau mencatat pengembalian aset.' : 'Perbarui detail pengajuan Anda sebelum diproses oleh Administrator.' }}
                        </p>
                    </div>

                    {{-- Badge Status Saat Ini --}}
                    @php
                        $statusColor = match ($peminjaman->status) {
                            'Menunggu ACC' => 'bg-yellow-200 text-yellow-800',
                            'Dipinjam' => 'bg-blue-200 text-blue-800',
                            'Dikembalikan' => 'bg-green-200 text-green-800',
                            'Ditolak', 'Terlambat' => 'bg-red-200 text-red-800',
                            default => 'bg-gray-200 text-gray-800',
                        };
                    @endphp
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold border border-white/50 shadow-sm whitespace-nowrap {{ $statusColor }}">
                        Status: {{ $peminjaman->status }}
                    </span>
                </div>

                <div class="p-6">

                    {{-- Info Peminjam (Hanya muncul jika yang buka adalah Administrator) --}}
                    @if (auth()->user()->role === 'Administrator')
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 flex items-center gap-4">
                            <div
                                class="h-10 w-10 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold">
                                {{ substr($peminjaman->user->nama_lengkap, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Diajukan oleh</p>
                                <p class="font-bold text-gray-900">{{ $peminjaman->user->nama_lengkap }} <span
                                        class="text-sm font-normal text-gray-500">({{ $peminjaman->user->role }})</span>
                                </p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('peminjaman._form')
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
