<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Change Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.avatar') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex flex-col items-center gap-4">
            <!-- Hiển thị ảnh hiện tại -->
            <div>
                @if ($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded border">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="w-32 h-32 rounded border">
                @endif
            </div>

            <!-- Form chọn ảnh mới -->
            <div>
                <x-input-label for="avatar" :value="__('Choose New Avatar')" />
                <input type="file" id="avatar" name="avatar"
                    class=" mt-1 block w-full" />
                <x-input-error class="mt-1 block w-full" :messages="$errors->get('avatar')" />
            </div>
        </div>






        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
