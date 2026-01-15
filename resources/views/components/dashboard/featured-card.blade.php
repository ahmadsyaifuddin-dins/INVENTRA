@props(['value'])

<div
    class="relative bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-lg p-6 text-white overflow-hidden transform hover:scale-105 transition-all duration-300">

    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-white opacity-10 blur-xl"></div>
    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>

    <div class="relative z-10 flex items-center justify-between mb-4">
        <div>
            <p
                class="text-xs font-bold text-indigo-100 uppercase tracking-wider border-b border-indigo-400 pb-1 inline-block">
                Aset Fisik
            </p>
            <h3 class="text-4xl font-extrabold text-white mt-2 flex items-baseline gap-2">
                {{ $value }} <span class="text-base font-normal text-indigo-200">Unit</span>
            </h3>
        </div>
        <div class="p-4 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl border border-white/10 shadow-inner">
            <i class="fas fa-dolly fa-2x text-white"></i>
        </div>
    </div>

    <div class="relative z-10 flex items-center justify-between mt-2">
        <p class="text-xs text-indigo-100 opacity-90">
            Terdistribusi & terlacak sistem
        </p>
        <i class="fas fa-arrow-right opacity-50 text-sm"></i>
    </div>
</div>
