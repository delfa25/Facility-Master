<x-guest-layout>
    <div class="w-full max-w-md space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Facility Master</h1>
            <p class="mt-2 text-sm text-gray-600">{{ __('Create your account') }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
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

                <div class="flex items-center justify-between pt-2">
                    <a class="text-sm text-purple-700 hover:text-purple-500 font-medium" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <p class="text-center text-xs text-gray-400">© {{ date('Y') }} Facility Master</p>
    </div>
</x-guest-layout>
