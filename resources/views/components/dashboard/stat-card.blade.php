@props(['title', 'value', 'subtitle', 'color', 'icon'])

<div
    class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-{{ $color }}-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $title }}</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $value }}</h3>
        </div>
        <div
            class="p-3 bg-{{ $color }}-100 rounded-full text-{{ $color }}-600 group-hover:bg-{{ $color }}-600 group-hover:text-white transition duration-300">
            <i class="{{ $icon }} fa-lg"></i>
        </div>
    </div>
    <p class="text-xs text-gray-400 flex items-center gap-1">
        {{ $subtitle }}
    </p>
</div>
