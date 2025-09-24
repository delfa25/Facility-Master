<x-guest-layout>
    <div class="w-full max-w-md space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Facility Master</h1>
            <p class="mt-2 text-sm text-gray-600">{{ __('Forgot your password?') }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('No problem. Enter your email and we will send you a reset link.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-primary-button class="w-full justify-center py-3 text-base">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <p class="text-center text-xs text-gray-400">© {{ date('Y') }} Facility Master</p>
    </div>
</x-guest-layout>
