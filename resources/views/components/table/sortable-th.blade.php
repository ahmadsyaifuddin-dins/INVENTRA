@props(['name', 'label'])

@php
    // Cek apakah kolom ini yang sedang disortir
    $isActive = request('sort') === $name;

    // Tentukan arah selanjutnya:
    // Jika aktif & sedang ASC -> maka selanjutnya DESC
    // Jika tidak (kolom baru atau sedang DESC) -> maka selanjutnya ASC
    $nextDirection = $isActive && request('direction') === 'asc' ? 'desc' : 'asc';

    // Generate URL
    $url = request()->fullUrlWithQuery(['sort' => $name, 'direction' => $nextDirection]);
@endphp

<th scope="col"
    class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider cursor-pointer hover:bg-indigo-100 transition group select-none"
    onclick="window.location.href='{{ $url }}'">

    <div class="flex items-center justify-between">
        <span>{{ $label }}</span>

        <span class="ml-1 flex items-center">
            @if ($isActive)
                @if (request('direction') === 'asc')
                    <svg class="w-3 h-3 text-indigo-600 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                    </svg>
                @else
                    <svg class="w-3 h-3 text-indigo-600 font-bold" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            @else
                <svg class="w-3 h-3 text-gray-400 opacity-50 group-hover:opacity-100 transition" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                </svg>
            @endif
        </span>
    </div>
</th>
