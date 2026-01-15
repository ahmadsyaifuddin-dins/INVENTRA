@props(['url'])

<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <div class="w-full md:w-auto">
        {{ $slot }}
    </div>

    <div class="w-full md:w-auto flex items-center gap-2 relative" x-data="{ showFilter: false }">

        <form action="{{ $url }}" method="GET" class="relative w-full md:w-64">
            @foreach (request()->except('search', 'page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </form>

        @if (isset($filter))
            <button @click="showFilter = !showFilter"
                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-3 rounded-lg shadow-sm transition flex items-center gap-2"
                :class="{ 'bg-indigo-50 border-indigo-300 text-indigo-700': showFilter }">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </button>
        @endif

        @if (isset($filter))
            <div x-show="showFilter" @click.away="showFilter = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="absolute right-0 top-full mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 z-50 p-4"
                style="display: none;">

                <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Filter Data</h4>

                <form action="{{ $url }}" method="GET">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{ $filter }}

                    <div class="mt-4 flex justify-between">
                        <a href="{{ $url }}"
                            class="text-xs text-gray-500 hover:text-gray-700 underline pt-2">Reset</a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
