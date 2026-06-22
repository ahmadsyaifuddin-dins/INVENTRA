<x-app-layout>
    <x-slot name="header">
        {{ __('Data Peminjaman Aset') }}
    </x-slot>

    <x-table.search-header :url="route('peminjaman.index')">
        <div>
            <h3 class="text-gray-800 font-bold text-xl">Daftar Peminjaman</h3>
            <p class="text-gray-500 text-sm">
                {{ auth()->user()->role === 'Pegawai' ? 'Riwayat pengajuan peminjaman aset Anda.' : 'Kelola pengajuan dan lacak aset yang sedang dipinjam.' }}
            </p>
        </div>

        <x-slot name="filter">
            {{-- Slot filter jika diperlukan di masa depan --}}
        </x-slot>
    </x-table.search-header>

    {{-- Tombol Tambah hanya relevan untuk diajukan --}}
    <div class="mb-4 flex flex-col sm:flex-row justify-end gap-3">
        {{-- TOMBOL BULK REMINDER (Hanya Admin) --}}
        @if (auth()->user()->role === 'Administrator')
            <form action="{{ route('peminjaman.remindBulk') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    onclick="return confirm('Kirim WA massal ke semua peminjam yang mendekati batas waktu (H-2)?')"
                    class="inline-flex bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow transition items-center gap-2 text-sm w-full sm:w-auto justify-center">
                    <i class="fab fa-whatsapp text-lg"></i>
                    Ingatkan Semua (H-2)
                </button>
            </form>
        @endif

        <a href="{{ route('peminjaman.create') }}"
            class="inline-flex bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition items-center gap-2 text-sm w-full sm:w-auto justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ auth()->user()->role === 'Administrator' ? 'Catat Peminjaman' : 'Ajukan Peminjaman' }}
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">No
                        </th>

                        {{-- Nama Peminjam Hanya Tampil untuk Admin/Gudang --}}
                        @if (auth()->user()->role !== 'Pegawai')
                            <x-table.sortable-th name="user_id" label="Peminjam" />
                        @endif

                        <x-table.sortable-th name="barang_id" label="Aset Dipinjam" />
                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">
                            Durasi</th>
                        <x-table.sortable-th name="status" label="Status" />
                        <th class="px-6 py-3 text-right text-xs font-bold text-indigo-800 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjamans as $index => $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $peminjamans->firstItem() + $index }}
                            </td>

                            @if (auth()->user()->role !== 'Pegawai')
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $p->user->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->user->role }}</div>
                                </td>
                            @endif

                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $p->barang->nama_barang }}</div>
                                <div
                                    class="text-xs text-gray-500 font-mono bg-gray-100 px-1 py-0.5 rounded inline-block mt-1">
                                    {{ $p->barang->kode_barang }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span class="font-medium text-indigo-600">Pinjam:</span>
                                    {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-900 mt-1">
                                    <span class="font-medium text-red-600">Batas:</span>
                                    {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColor = match ($p->status) {
                                        'Menunggu ACC' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Dipinjam' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'Dikembalikan' => 'bg-green-100 text-green-800 border-green-200',
                                        'Ditolak', 'Terlambat' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200',
                                    };
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusColor }}">
                                    {{ $p->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                {{-- LOGIKA TOMBOL AKSI --}}
                                @if (auth()->user()->role === 'Administrator')
                                    {{-- Logika Tombol WA Satuan (H-2, H-1, Hari Ini, atau Terlambat) --}}
                                    @php
                                        $tKembali = \Carbon\Carbon::parse($p->tanggal_kembali)->startOfDay();
                                        $selisih = now()->startOfDay()->diffInDays($tKembali, false);
                                        $tampilTombolWa = $p->status === 'Dipinjam' && $selisih <= 2;
                                    @endphp

                                    @if ($tampilTombolWa)
                                        <form action="{{ route('peminjaman.remindSingle', $p->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-800 mr-3 font-semibold inline-flex items-center"
                                                title="Kirim WA Pengingat">
                                                <i class="fab fa-whatsapp mr-1 text-base"></i> Ingatkan
                                            </button>
                                        </form>
                                    @endif
                                    {{-- Admin bisa memproses semua --}}
                                    <a href="{{ route('peminjaman.edit', $p->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i>
                                        {{ $p->status === 'Menunggu ACC' ? 'Proses ACC' : 'Edit' }}
                                    </a>
                                    <x-forms.delete-button :action="route('peminjaman.destroy', $p->id)" />
                                @elseif(auth()->user()->role === 'Pegawai')
                                    {{-- Pegawai hanya bisa edit/hapus jika belum di proses --}}
                                    @if ($p->status === 'Menunggu ACC')
                                        <a href="{{ route('peminjaman.edit', $p->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold inline-flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <x-forms.delete-button :action="route('peminjaman.destroy', $p->id)" />
                                    @else
                                        <span class="text-gray-400 italic text-xs">Terkunci (Telah Diproses)</span>
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role !== 'Pegawai' ? '6' : '5' }}"
                                class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-folder-open text-gray-300 text-4xl mb-3"></i>
                                    <p>Belum ada riwayat peminjaman aset.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-app-layout>
