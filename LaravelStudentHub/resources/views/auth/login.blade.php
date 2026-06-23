<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-mail:')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Hasło:')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-left justify-start mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md mr-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Zapomniałeś/aś hasła?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                <i class="bi bi-box-arrow-in-right mr-2"></i>
                Zaloguj
            </x-primary-button>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 flex items-center justify-end mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <span class="mr-2 text-sm text-gray-600">{{ __('Zapamiętaj mnie') }}</span>
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            </label>
        </div>

        
        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600">
                Pierwszy raz w StudentHub?
            </span>

            <a href="{{ route('register') }}"
            class="text-accent font-semibold hover:underline ml-1">
                Utwórz konto
            </a>
        </div>
    </form>
</x-guest-layout>
