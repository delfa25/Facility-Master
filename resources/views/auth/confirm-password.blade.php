<x-guest-layout>
    <div class="w-full max-w-md space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Facility Master</h1>
            <p class="mt-2 text-sm text-gray-600">{{ __('Please confirm your password to continue') }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-primary-button class="w-full justify-center py-3 text-base">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <p class="text-center text-xs text-gray-400">© {{ date('Y') }} Facility Master</p>
    </div>
</x-guest-layout>
