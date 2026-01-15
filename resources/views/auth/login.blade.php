<x-guest-layout>
    <a href="/" class="flex justify-center items-center">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </a>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-4">
        @csrf

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input type="text" name="username" id="username" value="{{ old('username') }}"
                class="block mt-1 w-full" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input type="password" name="password" id="password" class="block mt-1 w-full" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-between mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox text-indigo-600 rounded border-gray-300" name="remember">
                <span class="mx-2 text-gray-600 text-sm">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="block text-sm font-medium text-indigo-700 hover:underline"
                    href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
