<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Facility Master</h1>
                <p class="mt-2 text-sm text-gray-600">Connectez-vous à votre espace</p>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-purple-700 shadow-sm focus:ring-purple-600" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-purple-700 hover:text-purple-500 font-medium" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center py-3 text-base bg-purple-700 hover:bg-purple-500 focus:ring-purple-600">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            <p class="text-center text-xs text-gray-400">© {{ date('Y') }} Facility Master</p>
        </div>
    </div>
</x-guest-layout>
