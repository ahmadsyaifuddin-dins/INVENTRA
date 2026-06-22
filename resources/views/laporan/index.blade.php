<x-app-layout>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pusat Informasi & Cetak Laporan</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan pilih klasifikasi dokumen laporan berkala di bawah ini untuk
            melihat detail fisik audit atau mengunduh salinan berkas PDF resmi.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        {{-- LAPORAN 1: DATA INDUK BARANG --}}
        <a href="{{ route('laporan.barang') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mb-4 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <i class="fas fa-box fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Laporan Aset</h3>
                <p class="text-xs text-gray-500 mt-2">Daftar keseluruhan inventaris & filter tanggal masuk barang.</p>
            </div>
        </a>

        {{-- LAPORAN 2: DISTRIBUSI RUANGAN --}}
        <a href="{{ route('laporan.distribusi') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                    <i class="fas fa-dolly fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Distribusi Ruangan</h3>
                <p class="text-xs text-gray-500 mt-2">Kartu Inventaris Ruangan (KIR) per wilayah penempatan fisik.</p>
            </div>
        </a>

        {{-- LAPORAN 3: KONDISI ASET --}}
        <a href="{{ route('laporan.kondisi') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-rose-100 rounded-full flex items-center justify-center text-rose-600 mb-4 group-hover:bg-rose-600 group-hover:text-white transition">
                    <i class="fas fa-heart-broken fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Kondisi Aset</h3>
                <p class="text-xs text-gray-500 mt-2">Rekapitulasi berkas kuantitas barang baik, rusak ringan & berat.
                </p>
            </div>
        </a>

        {{-- LAPORAN 4: RIWAYAT MUTASI --}}
        <a href="{{ route('laporan.mutasi') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fas fa-history fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Riwayat Mutasi</h3>
                <p class="text-xs text-gray-500 mt-2">Log pelacakan kronologis pergerakan posisi barang masuk/keluar.
                </p>
            </div>
        </a>

        {{-- LAPORAN 5: PER KATEGORI --}}
        <a href="{{ route('laporan.per_kategori') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                    <i class="fas fa-tags fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Per Kategori</h3>
                <p class="text-xs text-gray-500 mt-2">Laporan komparasi data pengelompokan jenis rumpun aset.</p>
            </div>
        </a>

        {{-- LAPORAN 6: PEMINJAMAN AKTIF & KETERLAMBATAN --}}
        <a href="{{ route('laporan.peminjaman') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-amber-100 rounded-full flex items-center justify-center text-amber-600 mb-4 group-hover:bg-amber-600 group-hover:text-white transition">
                    <i class="fas fa-folder-open fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Peminjaman Aktif</h3>
                <p class="text-xs text-gray-500 mt-2">Daftar sisa durasi masa pinjam & info keterlambatan pengembalian.
                </p>
            </div>
        </a>

        {{-- LAPORAN 7: REKAP STATISTIK PER PEGAWAI --}}
        <a href="{{ route('laporan.per_pegawai') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-teal-100 rounded-full flex items-center justify-center text-teal-600 mb-4 group-hover:bg-teal-600 group-hover:text-white transition">
                    <i class="fas fa-user-check fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Statistik Pegawai</h3>
                <p class="text-xs text-gray-500 mt-2">Rapor frekuensi peminjaman serta tingkat kepatuhan ketepatan
                    waktu.</p>
            </div>
        </a>

        {{-- LAPORAN 8: AGENDA MAINTENANCE & PENYUSUTAN --}}
        <a href="{{ route('laporan.maintenance') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-orange-100 rounded-full flex items-center justify-center text-orange-600 mb-4 group-hover:bg-orange-600 group-hover:text-white transition">
                    <i class="fas fa-tools fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Jadwal & Agenda Aset</h3>
                <p class="text-xs text-gray-500 mt-2">Prediksi waktu servis berkala serta estimasi ambang batas
                    penyusutan aset.</p>
            </div>
        </a>

        {{-- LAPORAN 9: HASIL AUDIT STOK OPNAME --}}
        <a href="{{ route('laporan.audit') }}"
            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition border border-gray-100 text-center group flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-600 mb-4 group-hover:bg-slate-600 group-hover:text-white transition">
                    <i class="fas fa-file-invoice fa-2x"></i>
                </div>
                <h3 class="font-bold text-gray-800">Hasil Audit Opname</h3>
                <p class="text-xs text-gray-500 mt-2">Rangkuman hasil pemeriksaan fisik berkala selisih stok barang
                    rusak/hilang.</p>
            </div>
        </a>

    </div>
</x-app-layout>
