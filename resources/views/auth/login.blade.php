<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - INVENTRA</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-white">

    <div class="min-h-screen flex">

        <div
            class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 z-10 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">

                <div class="text-center">
                    <img class="h-24 w-auto mx-auto mb-4" src="{{ asset('logo/logo.png') }}" alt="Logo Kejaksaan">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        INVENTRA
                    </h2>
                    <p class="mt-2 text-sm text-gray-500">
                        Sistem Inventaris Kejaksaan Negeri<br>Banjarmasin
                    </p>
                </div>

                <div class="mt-10">
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700"> Username </label>
                            <div class="mt-1">
                                <input id="username" name="username" type="text" autocomplete="username" required
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                            </div>
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-900 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                                Masuk Aplikasi
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-10 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} INVENTRA - Kejaksaan Negeri Banjarmasin
                </div>

            </div>
        </div>

        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('img/gedung.png') }}"
                alt="Gedung Kejaksaan">

            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 to-indigo-800 opacity-30 mix-blend-multiply">
            </div>

            <div class="absolute bottom-0 left-0 p-20 text-white z-20">
                <h1 class="text-4xl font-bold mb-4 drop-shadow-lg">Selamat Datang</h1>
                <p class="text-lg text-indigo-100 max-w-lg drop-shadow-md backdrop-blur-sm">
                    Sistem Pengelolaan Inventaris Barang Milik Negara yang transparan, akuntabel, dan modern.
                </p>
            </div>
        </div>

    </div>
</body>

</html>
