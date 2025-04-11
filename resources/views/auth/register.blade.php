<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ url('/') }}"
                class="text-sm text-dark-500 hover:text-dark-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-500">
                {{ __('Home') }}
            </a>
            <div class="flex items-center space-x-4">
                <a class="text-sm text-dark-500 hover:text-dark-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button
                    class="px-6 py-2 bg-dark-500 text-white rounded-md hover:bg-dark-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-500">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
