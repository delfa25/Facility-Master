<div class="sticky top-0 z-50 flex justify-between items-center bg-gray-100 border-b-2 border-gray-200 px-4 py-4 ml-64">
    <div class="text-gray-600 font-bold text-lg">{{ date('d/m/Y') }}</div>
    <div class="flex items-center gap-4">
        @auth
            <span class="hidden sm:inline text-sm text-black-500">
                {{ Auth::user()->name ?? Auth::user()->email }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">
                    Se déconnecter
                </button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="text-white hover:text-gray-300" title="Se connecter">
                <i class="fa-solid fa-user"></i>
            </a>
        @endguest
    </div>
</div>
