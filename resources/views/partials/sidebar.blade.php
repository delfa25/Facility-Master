<nav x-data="sidebarState()" x-init="init()" class="fixed top-0 left-0 h-screen w-64 bg-gray-100 shadow-md pt-5">
    <a href="#" class="block mx-auto mb-5 w-24">
        <img src="{{ asset('images/higher-education.png') }}" alt="Logo" class="mx-auto">
    </a>
    <ul class="flex flex-col">
        <!-- Général -->
        <li class="px-5 pt-2 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">Général</li>
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="block px-5 py-2 {{ request()->routeIs('dashboard') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-gauge mr-2"></i> Tableau de Bord
            </a>
        </li>

        <!-- Gestion des personnes (permission-based) -->
        @canany(['etudiant.view','enseignant.view','inscription.view'])
        <li class="px-5 mt-4 pt-2 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
            <button type="button" class="w-full text-left flex items-center justify-between text-gray-600 hover:text-gray-800"
                    :aria-expanded="open.people"
                    @click="toggle('people')">
                <span><i class="fa-solid fa-users mr-2"></i> Gestion des personnes</span>
                <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open.people ? 'rotate-180' : ''"></i>
            </button>
        </li>
        @can('etudiant.view')
        <li class="nav-item" x-show="open.people" x-cloak>
            <a href="{{ route('etudiants.index') }}" class="block px-5 py-2 {{ request()->routeIs('etudiants.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-user-graduate mr-2"></i> Étudiants
            </a>
        </li>
        @endcan
        @can('enseignant.view')
        <li class="nav-item" x-show="open.people" x-cloak>
            <a href="{{ route('enseignants.index') }}" class="block px-5 py-2 {{ request()->routeIs('enseignants.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-chalkboard-user mr-2"></i> Enseignants
            </a>
        </li>
        @endcan
        @can('inscription.view')
        <li class="nav-item" x-show="open.people" x-cloak>
            <a href="{{ route('inscriptions.index') }}" class="block px-5 py-2 {{ request()->routeIs('inscriptions.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-clipboard-check mr-2"></i> Inscriptions
            </a>
        </li>
        @endcan
        @endcanany

        <!-- Paramétrage académique (permission-based) -->
        @canany(['filiere.view','annee.view','niveau.view','semestre.view','classe.view','cycle.view','salle.view','typeseance.view'])
        <li class="px-5 mt-4 pt-2 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
            <button type="button" class="w-full text-left flex items-center justify-between text-gray-600 hover:text-gray-800"
                    :aria-expanded="open.academic"
                    @click="toggle('academic')">
                <span><i class="fa-solid fa-diagram-project mr-2"></i> Paramétrage académique</span>
                <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open.academic ? 'rotate-180' : ''"></i>
            </button>
        </li>
        @can('filiere.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('filieres.index') }}" class="block px-5 py-2 {{ request()->routeIs('filieres.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-diagram-project mr-2"></i> Filières
            </a>
        </li>
        @endcan
        @can('academic_year.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('academic-years.index') }}" class="block px-5 py-2 {{ request()->routeIs('academic-years.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-regular fa-calendar mr-2"></i> Années académiques
            </a>
        </li>
        @endcan
        @can('niveau.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('niveaux.index') }}" class="block px-5 py-2 {{ request()->routeIs('niveaux.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-layer-group mr-2"></i> Niveaux
            </a>
        </li>
        @endcan
        @can('semestre.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('semestres.index') }}" class="block px-5 py-2 {{ request()->routeIs('semestres.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-regular fa-calendar-days mr-2"></i> Semestres
            </a>
        </li>
        @endcan
        @can('classe.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('classes.index') }}" class="block px-5 py-2 {{ request()->routeIs('classes.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-school mr-2"></i> Classes
            </a>
        </li>
        @endcan
        @can('cycle.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('cycles.index') }}" class="block px-5 py-2 {{ request()->routeIs('cycles.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-shapes mr-2"></i> Cycles
            </a>
        </li>
        @endcan
        @can('salle.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('salles.index') }}" class="block px-5 py-2 {{ request()->routeIs('salles.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-regular fa-building mr-2"></i> Salles
            </a>
        </li>
        @endcan
        @can('typeseance.view')
        <li class="nav-item" x-show="open.academic" x-cloak>
            <a href="{{ route('typeseances.index') }}" class="block px-5 py-2 {{ request()->routeIs('typeseances.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-list-check mr-2"></i> Types de séance
            </a>
        </li>
        @endcan
        @endcanany

        <!-- Sécurité (Admin + permission.view) -->
        @role('ADMINISTRATEUR')
        <li class="px-5 mt-4 pt-2 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">Sécurité</li>
        @can('permission.view')
        <li class="nav-item">
            <a href="{{ route('permissions.index') }}" class="block px-5 py-2 {{ request()->routeIs('permissions.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-key mr-2"></i> Permissions
            </a>
        </li>
        @endcan
        @endrole

        <!-- Administration système -->
        @role('SUPERADMIN')
        <li class="px-5 mt-4 pt-2 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
            <button type="button" class="w-full text-left flex items-center justify-between text-gray-600 hover:text-gray-800"
                    :aria-expanded="open.system"
                    @click="toggle('system')">
                <span><i class="fa-solid fa-gears mr-2"></i> Administration système</span>
                <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open.system ? 'rotate-180' : ''"></i>
            </button>
        </li>
        <li class="nav-item" x-show="open.system" x-cloak>
            <a href="{{ route('users.index') }}" class="block px-5 py-2 {{ request()->routeIs('users.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-user mr-2"></i> Utilisateurs
            </a>
        </li>
        <li class="nav-item" x-show="open.system" x-cloak>
            <a href="{{ route('roles.index') }}" class="block px-5 py-2 {{ request()->routeIs('roles.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-id-badge mr-2"></i> Profils (rôles)
            </a>
        </li>
        <li class="nav-item" x-show="open.system" x-cloak>
            <a href="{{ route('parametres.index') }}" class="block px-5 py-2 {{ request()->routeIs('parametres.*') ? 'bg-purple-700 text-white font-semibold rounded-md' : 'text-gray-800 hover:bg-gray-200 hover:text-black rounded-md' }}">
                <i class="fa-solid fa-gear mr-2"></i> Paramètres
            </a>
        </li>
        @endrole
    </ul>
</nav>

<script>
  function sidebarState() {
    return {
      storageKey: 'sidebar-open-groups',
      open: { people: false, academic: false, system: false },
      init() {
        // Load saved state
        const raw = localStorage.getItem(this.storageKey);
        if (raw) {
          try { this.open = { ...this.open, ...JSON.parse(raw) }; } catch (e) {}
        }
        // Auto-open based on current path
        const path = window.location.pathname || '';
        if (/\/(etudiants|enseignants|inscriptions)/.test(path)) this.open.people = true;
        if (/\/(filieres|academic-years|niveaux|semestres|classes|cycles|salles|typeseances)/.test(path)) this.open.academic = true;
        if (/\/(users|roles|permissions|parametres)/.test(path)) this.open.system = true;
        this.persist();
      },
      toggle(group) { this.open[group] = !this.open[group]; this.persist(); },
      persist() { localStorage.setItem(this.storageKey, JSON.stringify(this.open)); },
    }
  }
</script>

