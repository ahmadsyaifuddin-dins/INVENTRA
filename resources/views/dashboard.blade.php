<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard Overview') }}
    </x-slot>

    <style>
        @keyframes wave {
            0% {
                transform: rotate(0.0deg);
            }

            10% {
                transform: rotate(14.0deg);
            }

            /* Miring Kanan */
            20% {
                transform: rotate(-8.0deg);
            }

            /* Miring Kiri */
            30% {
                transform: rotate(14.0deg);
            }

            /* Miring Kanan */
            40% {
                transform: rotate(-4.0deg);
            }

            /* Miring Kiri */
            50% {
                transform: rotate(10.0deg);
            }

            /* Miring Kanan */
            60% {
                transform: rotate(0.0deg);
            }

            /* Diam */
            100% {
                transform: rotate(0.0deg);
            }

            /* Diam sampai loop selesai */
        }

        .waving-hand {
            animation-name: wave;
            animation-duration: 2.5s;
            /* Durasi satu putaran sapaan */
            animation-iteration-count: infinite;
            /* Gerak terus menerus */
            transform-origin: 70% 70%;
            /* Titik putar di pergelangan tangan */
            display: inline-block;
        }
    </style>

    <div class="relative bg-indigo-600 md:pt-10 pb-10 pt-10 rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-32 h-32 rounded-full bg-indigo-500 opacity-50 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-32 h-32 rounded-full bg-indigo-400 opacity-30 blur-2xl"></div>

        <div class="relative px-6 md:px-10">
            <h2 class="text-white text-3xl font-bold mb-2 flex items-center gap-3">
                Halo, {{ Auth::user()->nama_lengkap }}!
                <i class="fas fa-hand-paper text-yellow-300 waving-hand text-3xl"></i>
            </h2>
            <p class="text-indigo-100 text-lg opacity-90">
                Selamat datang di <span class="font-bold">INVENTRA</span> (Sistem Inventaris Kejaksaan Negeri
                Banjarmasin).
                <br>Anda login sebagai <span
                    class="bg-indigo-800 text-indigo-100 text-xs font-semibold px-2 py-1 rounded uppercase tracking-wide ml-1">{{ Auth::user()->role }}</span>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Data Barang</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalJenisBarang }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                    <i class="fas fa-box fa-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400">Total jenis aset terdaftar</p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Ruangan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalRuangan }}</h3>
                </div>
                <div class="p-3 bg-emerald-100 rounded-full text-emerald-600">
                    <i class="fas fa-building fa-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400">Lokasi penyimpanan aktif</p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Aset Fisik</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAsetFisik }} <span
                            class="text-sm font-normal text-gray-500">Unit</span></h3>
                </div>
                <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                    <i class="fas fa-dolly fa-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400">Terdistribusi di ruangan</p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-red-500 uppercase tracking-wider">Rusak Berat</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $barangRusak }} <span
                            class="text-sm font-normal text-gray-500">Unit</span></h3>
                </div>
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400">Segera proses penghapusan/lelang</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('barang.create') }}"
                    class="flex items-center p-3 bg-gray-50 hover:bg-indigo-50 rounded-lg transition group">
                    <div
                        class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-gray-700">Tambah Barang Baru</p>
                        <p class="text-xs text-gray-400">Input data aset master</p>
                    </div>
                </a>

                <a href="{{ route('penempatan.create') }}"
                    class="flex items-center p-3 bg-gray-50 hover:bg-emerald-50 rounded-lg transition group">
                    <div
                        class="p-2 bg-emerald-100 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i class="fas fa-share-square"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-gray-700">Distribusi Aset</p>
                        <p class="text-xs text-gray-400">Pindahkan barang ke ruangan</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Status Sistem</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Modul</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">Database</td>
                            <td class="px-6 py-4"><span
                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Connected</span>
                            </td>
                            <td class="px-6 py-4">Sistem terhubung ke Database Utama</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">Mode Pengguna</td>
                            <td class="px-6 py-4"><span
                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>
                            </td>
                            <td class="px-6 py-4">Login sebagai {{ Auth::user()->role }}</td>
                        </tr>
                        <tr class="bg-white">
                            <td class="px-6 py-4 font-medium text-gray-900">Versi Aplikasi</td>
                            <td class="px-6 py-4"><span
                                    class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">v1.0
                                    (PKL)</span></td>
                            <td class="px-6 py-4">Rilis Perdana</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Tips Penggunaan</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Pastikan untuk selalu melakukan backup data sebelum mencetak laporan akhir bulan.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
