<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="mt-4 flex items-center justify-center">
                <div class="text-sm">
                    <a href="{{ route('register') }}"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Don\'t have an account?') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>



        <div class="flex items-center justify-between mt-6">
            <a href="{{ url('/') }}"
                class="text-sm text-dark-500 hover:text-dark-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-500">
                {{ __('Home') }}
            </a>
            <div class="flex items-center space-x-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-dark-500 hover:text-dark-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="px-6 py-2 bg-dark-500 text-white rounded-md hover:bg-dark-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-500">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
