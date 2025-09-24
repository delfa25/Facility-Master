@extends('base')
@section('title', 'Gestion des enseignants')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Liste des enseignants</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Total</div>
                        <div class="text-2xl font-bold">{{ $counts['total'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Avec grade</div>
                        <div class="text-2xl font-bold text-green-700">{{ $counts['with_grade'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-gray-500 text-sm">Sans grade</div>
                        <div class="text-2xl font-bold text-gray-700">{{ $counts['without_grade'] ?? 0 }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <form method="GET" action="{{ route('enseignants.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher (nom, email)" class="p-2 border border-gray-300 rounded w-72">
                        <input type="text" name="grade" value="{{ $grade ?? '' }}" placeholder="Grade" class="p-2 border border-gray-300 rounded">
                        <input type="text" name="specialite" value="{{ $specialite ?? '' }}" placeholder="Spécialité" class="p-2 border border-gray-300 rounded">
                        <input type="text" name="statut" value="{{ $statut ?? '' }}" placeholder="Statut" class="p-2 border border-gray-300 rounded">
                        <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
                    </form>
                    <a href="{{ route('enseignants.create') }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-600">Créer un enseignant</a>
                </div>

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Grade</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Spécialité</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Statut</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enseignants as $enseignant)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $enseignant->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $enseignant->prenom ?? '' }} {{ $enseignant->nom ?? '' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $enseignant->grade ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $enseignant->specialite ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $enseignant->statut ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a class="text-blue-600 hover:text-blue-900" href="{{ route('enseignants.show', $enseignant) }}">Voir</a>
                                                <a class="text-green-600 hover:text-green-900" href="{{ route('enseignants.edit', $enseignant) }}">Modifier</a>
                                                <form action="{{ route('enseignants.destroy', $enseignant) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet enseignant ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                            Aucun enseignant trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $enseignants->links() }}</div>
            </div>
        </main>
    </div>
</div>
@endsection
