<x-guest-layout>
    <div class="w-full max-w-md space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Facility Master</h1>
            <p class="mt-2 text-sm text-gray-600">{{ __('Verify your email') }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
            <div class="text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you. If you didn\'t receive the email, we\'ll gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="flex items-center justify-between pt-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-purple-700 hover:text-purple-500 font-medium">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
        <p class="text-center text-xs text-gray-400">© {{ date('Y') }} Facility Master</p>
    </div>
</x-guest-layout>
