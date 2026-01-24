<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed z-30 inset-y-0 left-0 w-72 transition duration-300 transform bg-indigo-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 border-r border-indigo-800">

    <div class="flex flex-col items-center justify-center mt-8">
        <div class="flex flex-col items-center gap-3">
            <div class="p-1.5 bg-white/10 rounded-full backdrop-blur-sm shadow-lg border border-white/20">
                <img src="{{ asset('logo/logo.png') }}" alt="Logo Kejaksaan"
                    class="h-16 w-16 object-contain drop-shadow-md">
            </div>

            <div class="text-center">
                <span class="text-white text-2xl font-bold tracking-widest block drop-shadow-md">INVENTRA</span>
                <span
                    class="inline-block mt-1 px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-indigo-800 text-indigo-100 border border-indigo-700 shadow-sm">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>
    </div>

    <nav class="mt-5 px-4 space-y-1 pb-6">

        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </x-slot>
            {{ __('Beranda') }}
        </x-nav-link>

        <div class="px-4 mt-5 mb-2 text-xs font-bold text-indigo-400 uppercase tracking-widest opacity-80">
            Master Data
        </div>

        @if (Auth::user()->role === 'Pegawai')
            <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
                <x-slot name="icon">
                    <i
                        class="fa-solid fa-user mr-3 {{ request()->routeIs('users.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"></i>
                </x-slot>
                {{ __('Data Pengguna') }}
            </x-nav-link>
        @endif

        <x-nav-link href="{{ route('kategori.index') }}" :active="request()->routeIs('kategori.*')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('kategori.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('kategori.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </x-slot>
            {{ __('Data Kategori') }}
        </x-nav-link>

        <x-nav-link href="{{ route('barang.index') }}" :active="request()->routeIs('barang.*')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('barang.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('barang.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </x-slot>
            {{ __('Data Barang') }}
        </x-nav-link>

        <x-nav-link href="{{ route('ruangan.index') }}" :active="request()->routeIs('ruangan.*')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('ruangan.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('ruangan.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </x-slot>
            {{ __('Data Ruangan') }}
        </x-nav-link>

        <div class="px-4 mt-5 mb-2 text-xs font-bold text-indigo-400 uppercase tracking-widest opacity-80">
            Transaksi
        </div>

        <x-nav-link href="{{ route('penempatan.index') }}" :active="request()->routeIs('penempatan.*')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('penempatan.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('penempatan.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </x-slot>
            {{ __('Distribusi Aset') }}
        </x-nav-link>

        <x-nav-link href="{{ route('opname.index') }}" :active="request()->routeIs('opname.*')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('opname.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <i
                    class="fas fa-clipboard-check mr-3 w-5 text-center {{ request()->routeIs('opname.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"></i>
            </x-slot>
            {{ __('Pemeriksaan Aset') }}
        </x-nav-link>

        <div class="px-4 mt-5 mb-2 text-xs font-bold text-indigo-400 uppercase tracking-widest opacity-80">
            Laporan
        </div>

        <x-nav-link href="{{ route('laporan.index') }}" :active="request()->routeIs('laporan.*')"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-indigo-700 text-white shadow-md ring-1 ring-indigo-600' : 'text-indigo-100 hover:bg-indigo-800/50 hover:text-white' }}">
            <x-slot name="icon">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('laporan.*') ? 'text-indigo-300' : 'text-indigo-400 group-hover:text-indigo-200' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </x-slot>
            {{ __('Laporan') }}
        </x-nav-link>

    </nav>
</div>
