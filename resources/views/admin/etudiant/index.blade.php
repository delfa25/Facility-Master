@extends('base')
@section('title', 'Gestion des étudiants')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Liste des étudiants</h1>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Total</div>
                        <div class="text-2xl font-bold">{{ $counts['total'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Actifs</div>
                        <div class="text-2xl font-bold text-green-700">{{ $counts['ACTIF'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Inactifs</div>
                        <div class="text-2xl font-bold text-gray-700">{{ $counts['INACTIF'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Diplômés</div>
                        <div class="text-2xl font-bold text-blue-700">{{ $counts['diplome'] ?? 0 }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <form method="GET" action="{{ route('etudiants.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher (nom, email, INE)" class="p-2 border border-gray-300 rounded w-72">
                        <select name="statut" class="p-2 border border-gray-300 rounded">
                            <option value="">Tous les statuts</option>
                            @foreach(($statuts ?? []) as $s)
                                <option value="{{ $s }}" {{ ($statut ?? '') === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">INE</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Statut</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Date inscription</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiants as $etudiant)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->INE }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->personne->prenom ?? '' }} {{ $etudiant->personne->nom ?? '' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($etudiant->statut === 'ACTIF') bg-green-100 text-green-800 
                                                @elseif($etudiant->statut === 'INACTIF') bg-gray-100 text-gray-800 
                                                @elseif($etudiant->statut === 'SUSPENDU') bg-yellow-100 text-yellow-800 
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ $etudiant->statut }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $etudiant->date_inscription ? $etudiant->date_inscription->format('d/m/Y') : '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a class="text-blue-600 hover:text-blue-900" href="{{ route('etudiants.show', $etudiant) }}">Voir</a>
                                                <a class="text-green-600 hover:text-green-900" href="{{ route('etudiants.edit', $etudiant) }}">Modifier</a>
                                                <form action="{{ route('etudiants.destroy', $etudiant) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet étudiant ?')">
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
                                            Aucun étudiant trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $etudiants->links() }}</div>
            </div>
        </main>
    </div>
</div>
@endsection
