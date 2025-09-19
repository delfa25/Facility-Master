@extends('base')
@section('title', 'Gestion des personnes')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Zone principale -->
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        <!-- Navbar -->
        @include('partials.navbar')

        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Liste des personnes</h1>

                <div class="flex items-center justify-between mb-4">
                    <form method="GET" action="{{ route('personnes.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher (nom, email, téléphone)" class="p-2 border border-gray-300 rounded w-72">
                        <select name="role" class="p-2 border border-gray-300 rounded">
                            <option value="">Tous les rôles</option>
                            @foreach(($roles ?? []) as $r)
                                <option value="{{ $r }}" {{ ($role ?? '') === $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
                    </form>
                    <a href="{{ route('personnes.create') }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-600">Créer une personne</a>
                </div>

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Téléphone</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Rôle</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($personnes as $personne)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $personne->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $personne->prenom }} {{ $personne->nom }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $personne->email }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $personne->phone }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                                @switch($personne->role ?? '')
                                                    @case('ADMINISTRATEUR') bg-red-100 text-red-800 @break
                                                    @case('ENSEIGNANT')      bg-blue-100 text-blue-800 @break
                                                    @case('ETUDIANT')        bg-green-100 text-green-800 @break
                                                    @default                 bg-gray-100 text-gray-800
                                                @endswitch">
                                                {{ ucfirst(strtolower($personne->role ?? 'invite')) }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a class="text-blue-600 hover:text-blue-900" href="{{ route('personnes.show', $personne) }}">Voir</a>
                                                <a class="text-green-600 hover:text-green-900" href="{{ route('personnes.edit', $personne) }}">Modifier</a>
                                                <form action="{{ route('personnes.destroy', $personne) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette personne ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                            Aucune personne trouvée
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $personnes->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

<div>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
</div>
