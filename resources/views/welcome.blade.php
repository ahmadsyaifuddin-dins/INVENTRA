<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVENTRA - Kejaksaan Negeri Banjarmasinnnnnnnnnnn</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="antialiased bg-gray-50 font-sans text-gray-900">

    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img class="h-10 w-auto mr-3" src="{{ asset('logo/logo.png') }}" alt="Logo">
                    <span class="font-bold text-xl text-gray-800 tracking-tight">INVENTRA</span>
                </div>
                <div class="flex items-center">
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-sm font-bold text-indigo-700 hover:text-indigo-900">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-900 rounded-lg hover:bg-indigo-800 transition focus:ring-4 focus:outline-none focus:ring-indigo-300">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login Pegawai
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-indigo-900 pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center">
            <div class="w-full lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0">
                <span
                    class="inline-block py-1 px-3 rounded bg-indigo-800 text-indigo-100 text-xs font-bold tracking-widest mb-4">SISTEM
                    INFORMASI MANAJEMEN ASET</span>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    Kelola Inventaris <br> <span class="text-yellow-400">Lebih Efisien.</span>
                </h1>
                <p class="text-lg text-indigo-200 mb-8 max-w-2xl mx-auto lg:mx-0">
                    Aplikasi resmi pengelolaan data barang milik negara pada Kejaksaan Negeri Banjarmasin. Memudahkan
                    pencatatan, penempatan, dan pelaporan aset.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#fitur"
                        class="px-8 py-3 text-base font-bold text-indigo-900 bg-white rounded-lg hover:bg-gray-100 transition shadow-lg">
                        Pelajari Fitur
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 text-base font-bold text-white border border-indigo-500 rounded-lg hover:bg-indigo-800 transition">
                        Akses Sistem
                    </a>
                </div>
            </div>
            <div class="w-full lg:w-1/2 lg:pl-10">
                <img src="{{ asset('img/gedung.png') }}" alt="Dashboard Preview"
                    class="rounded-xl shadow-2xl border-4 border-indigo-500/30 transform rotate-2 hover:rotate-0 transition duration-500">
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Fitur Unggulan</h2>
                <p class="mt-4 text-lg text-gray-500">Membantu tata kelola barang milik negara yang akuntabel.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-box-open fa-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pendataan Digital</h3>
                    <p class="text-gray-600">Digitalisasi data barang masuk, kondisi fisik, hingga spesifikasi teknis
                        secara terperinci.</p>
                </div>
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-lg transition">
                    <div
                        class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 mb-6">
                        <i class="fas fa-map-marked-alt fa-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tracking Lokasi</h3>
                    <p class="text-gray-600">Monitoring distribusi aset ke setiap ruangan. Mengetahui posisi aset secara
                        realtime.</p>
                </div>
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600 mb-6">
                        <i class="fas fa-file-pdf fa-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pelaporan Otomatis</h3>
                    <p class="text-gray-600">Cetak laporan inventaris, mutasi, dan kondisi barang dalam format PDF siap
                        cetak.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <img class="h-10 w-auto mr-3 grayscale opacity-80" src="{{ asset('logo/logo.png') }}"
                        alt="Logo">
                    <div>
                        <h4 class="font-bold text-lg">Kejaksaan Negeri Banjarmasin</h4>
                        <p class="text-gray-400 text-sm">Jl. Brigjen Hasan Basri No.3, Banjarmasin Utara</p>
                    </div>
                </div>
                <div class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} INVENTRA. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
