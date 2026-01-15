<header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-900 shadow-sm z-20">

    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
        <h2 class="text-xl font-bold text-indigo-900 ml-4 hidden md:block uppercase tracking-wide">
            {{ $header ?? 'INVENTRA' }}
        </h2>
    </div>

    <div class="flex items-center gap-4">

        <div x-data="{ notifOpen: false }" class="relative">
            <button @click="notifOpen = !notifOpen"
                class="relative z-10 block text-gray-500 hover:text-indigo-900 focus:outline-none transition duration-150">
                <i class="fas fa-bell fa-lg"></i>
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform bg-red-600 rounded-full border-2 border-white shadow-sm">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <div x-show="notifOpen" @click.away="notifOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-3 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-50 border border-gray-100 origin-top-right"
                style="display: none;">

                <div
                    class="py-2 px-4 bg-indigo-50 border-b border-indigo-100 text-sm font-bold text-indigo-900 flex justify-between items-center">
                    <span>Notifikasi</span>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <a href="{{ route('notifikasi.readAll') }}"
                            class="text-xs text-indigo-600 hover:text-indigo-800 underline">Tandai semua dibaca</a>
                    @endif
                </div>

                <div class="max-h-64 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ route('notifikasi.cek', $notification->id) }}"
                            class="flex items-start px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-full {{ $notification->data['color'] ?? 'bg-indigo-500' }} text-white shadow-sm">
                                    <i class="{{ $notification->data['icon'] ?? 'fas fa-info' }} text-xs"></i>
                                </span>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800">{{ $notification->data['title'] }}</p>
                                <p class="text-xs text-gray-600 mt-0.5">{{ $notification->data['message'] }}</p>
                                <p class="text-[10px] text-gray-400 mt-1 font-medium">
                                    {{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <i class="far fa-bell-slash text-gray-300 text-3xl mb-2"></i>
                            <p class="text-sm text-gray-500">Tidak ada notifikasi baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div x-data="{ userOpen: false }" class="relative">

            <button @click="userOpen = !userOpen"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                <div class="flex items-center gap-2">
                    <img class="h-8 w-8 rounded-full object-cover border border-gray-200 shadow-sm"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&background=312e81&color=ffffff"
                        alt="{{ Auth::user()->nama_lengkap }}" />

                    <div class="hidden md:flex flex-col items-start">
                        <span class="text-gray-800 font-bold leading-tight">{{ Auth::user()->nama_lengkap }}</span>
                        <span
                            class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider">{{ Auth::user()->role }}</span>
                    </div>

                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </button>

            <div x-show="userOpen" @click.away="userOpen = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 origin-top-right"
                style="display: none;">

                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>

    </div>
</header>
