@props(['user'])

<div class="relative bg-indigo-600 md:pt-10 pb-10 pt-10 rounded-xl shadow-lg overflow-hidden mb-8">

    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-32 h-32 rounded-full bg-indigo-500 opacity-50 blur-2xl"></div>
    <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-32 h-32 rounded-full bg-indigo-400 opacity-30 blur-2xl"></div>

    <div class="relative px-6 md:px-10 flex flex-col md:flex-row justify-between items-center">

        <div class="z-10">
            <h2 class="text-white text-3xl font-bold mb-2 flex items-center gap-3">
                Halo, {{ $user->nama_lengkap }}!
                <i class="fas fa-hand-paper text-yellow-300 waving-hand text-3xl drop-shadow-md"></i>
            </h2>

            <p class="text-indigo-100 text-lg opacity-90 leading-relaxed">
                Selamat datang di <span class="font-bold text-white">INVENTRA</span> (Sistem Inventaris Kejaksaan Negeri
                Banjarmasin).
                <br>
                Anda login sebagai
                <span
                    class="bg-indigo-800 text-indigo-100 text-xs font-semibold px-2 py-1 rounded uppercase tracking-wide ml-1 border border-indigo-500/50 shadow-sm">
                    {{ $user->role }}
                </span>
            </p>
        </div>

        <div class="hidden md:block opacity-10 transform translate-x-4">
            <i class="fas fa-cubes text-9xl text-white transform rotate-12"></i>
        </div>

    </div>
</div>
