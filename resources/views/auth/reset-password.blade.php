<x-guest-layout>
    <div class="w-full max-w-md space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Facility Master</h1>
            <p class="mt-2 text-sm text-gray-600">{{ __('Reset your password') }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div>
                    <x-primary-button class="w-full justify-center py-3 text-base">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <p class="text-center text-xs text-gray-400">© {{ date('Y') }} Facility Master</p>
    </div>
</x-guest-layout>
