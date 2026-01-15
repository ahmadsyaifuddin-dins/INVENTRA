<x-app-layout>
    <x-slot name="header">{{ __('Mulai Stock Opname') }}</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold mb-4">Langkah 1: Tentukan Lokasi & Waktu</h2>

        <form action="{{ route('opname.formulir') }}" method="GET">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Ruangan</label>
                <select name="ruangan_id" required class="w-full rounded-lg border-gray-300">
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach ($ruangans as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                    class="w-full rounded-lg border-gray-300">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg">
                Lanjut ke Pemeriksaan Fisik &rarr;
            </button>
        </form>
    </div>
</x-app-layout>
