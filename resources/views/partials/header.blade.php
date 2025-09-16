<nav class="bg-gray-900 text-white p-4 flex items-center justify-between">
    <ul class="flex items-center gap-4">
        <li>
            <a href="/" class="hover:text-gray-300">Home</a>
        </li>
    </ul>

    <div class="flex items-center gap-4">
        @auth
            <span class="hidden sm:inline text-sm text-gray-300">
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
</nav>