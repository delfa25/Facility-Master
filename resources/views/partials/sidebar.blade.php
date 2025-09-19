<nav class="fixed top-0 left-0 h-screen w-64 bg-gray-100 shadow-md pt-5">
    <a href="#" class="block mx-auto mb-5 w-24">
        <img src="{{ asset('images/higher-education.png') }}" alt="Logo" class="mx-auto">
    </a>
    <ul class="flex flex-col">
        <li class="nav-item"><a href="{{ route('dashboard') }}" class="block px-5 py-2 {{ request()->routeIs('dashboard') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Tableau de Bord</a></li>
        <li class="nav-item"><a href="{{ route('etudiants.index') }}" class="block px-5 py-2 {{ request()->routeIs('etudiants.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Gestion des étudiants</a></li>
        <li class="nav-item"><a href="{{ route('enseignants.index') }}" class="block px-5 py-2 {{ request()->routeIs('enseignants.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Gestion des professeurs</a></li>
        <li class="nav-item"><a href="{{ route('users.index') }}" class="block px-5 py-2 {{ request()->routeIs('users.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Gestion des utilisateurs</a></li>
        <li class="nav-item"><a href="{{ route('personnes.index') }}" class="block px-5 py-2 {{ request()->routeIs('personnes.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Gestion des personnes</a></li>
        <li class="nav-item"><a href="{{ route('parametres.index') }}" class="block px-5 py-2 {{ request()->routeIs('parametres.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Parametres</a></li>
        <li class="nav-item"><a href="{{ route('inscriptions.index') }}" class="block px-5 py-2 {{ request()->routeIs('inscriptions.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">Inscriptions</a></li>
        <li class="nav-item">
        <li class="nav-item">
        <li class="nav-item">
        <a href="{{ route('filieres.index') }}" class="block px-5 py-2 {{ request()->routeIs('filieres.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Filières
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('annees.index') }}" class="block px-5 py-2 {{ request()->routeIs('annees.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Années académiques
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('niveaux.index') }}" class="block px-5 py-2 {{ request()->routeIs('niveaux.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Niveaux
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('semestres.index') }}" class="block px-5 py-2 {{ request()->routeIs('semestres.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Semestres
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('salles.index') }}" class="block px-5 py-2 {{ request()->routeIs('salles.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Salles
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('typeseances.index') }}" class="block px-5 py-2 {{ request()->routeIs('typeseances.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Types de séance
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('classes.index') }}" class="block px-5 py-2 {{ request()->routeIs('classes.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Classes
        </a>
        </li>
        <li class="nav-item">
        <a href="{{ route('cycles.index') }}" class="block px-5 py-2 {{ request()->routeIs('cycles.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
            Cycles
        </a>
        </li>
    </ul>
</nav>

