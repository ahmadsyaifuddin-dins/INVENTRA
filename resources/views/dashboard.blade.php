<x-app-layout>

    @push('styles')
        <style>
            @keyframes wave {
                0% {
                    transform: rotate(0.0deg);
                }

                10% {
                    transform: rotate(14.0deg);
                }

                20% {
                    transform: rotate(-8.0deg);
                }

                30% {
                    transform: rotate(14.0deg);
                }

                40% {
                    transform: rotate(-4.0deg);
                }

                50% {
                    transform: rotate(10.0deg);
                }

                60% {
                    transform: rotate(0.0deg);
                }

                100% {
                    transform: rotate(0.0deg);
                }
            }

            .waving-hand {
                animation-name: wave;
                animation-duration: 2.5s;
                animation-iteration-count: infinite;
                transform-origin: 70% 70%;
                display: inline-block;
            }
        </style>
    @endpush

    <x-slot name="header">
        {{ __('Beranda') }}
    </x-slot>

    <x-dashboard.welcome-banner :user="Auth::user()" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <x-dashboard.stat-card title="Data Barang" :value="$totalJenisBarang" subtitle="Total jenis aset terdaftar" color="blue"
            icon="fas fa-box" />

        <x-dashboard.stat-card title="Ruangan" :value="$totalRuangan" subtitle="Lokasi penyimpanan aktif" color="emerald"
            icon="fas fa-building" />

        <x-dashboard.featured-card :value="$totalAsetFisik" />

        <x-dashboard.stat-card title="Rusak Berat" :value="$barangRusak . ' Unit'" subtitle="Segera proses lelang" color="red"
            icon="fas fa-exclamation-triangle" />

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <x-dashboard.quick-actions />

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i class="fas fa-server text-gray-400"></i> Status Sistem
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Komponen</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">Database Engine</td>
                            <td class="px-6 py-4"><span
                                    class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full ring-1 ring-green-600/20">Online</span>
                            </td>
                            <td class="px-6 py-4">MySQL Connected</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">Security Guard</td>
                            <td class="px-6 py-4"><span
                                    class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full ring-1 ring-blue-600/20">Active</span>
                            </td>
                            <td class="px-6 py-4">Session: {{ Auth::user()->role }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">Build Version</td>
                            <td class="px-6 py-4"><span
                                    class="bg-purple-100 text-purple-800 text-xs font-bold px-2.5 py-0.5 rounded-full ring-1 ring-purple-600/20">v1.0-beta</span>
                            </td>
                            <td class="px-6 py-4">Project PKL Kejaksaan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
