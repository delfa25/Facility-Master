@extends('base')
@section('title', 'Classes')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-7xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Gestion des classes</h1>

                <div class="flex items-center justify-between mb-4">
                    <form method="GET" action="{{ route('classes.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher (code, nom, filière, niveau)" class="p-2 border border-gray-300 rounded w-72">
                        <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
                    </form>
                    <a href="{{ route('classes.create') }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-600">Créer une classe</a>
                </div>

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Code</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Filière</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Niveau</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Salle</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Année</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Responsable</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $c)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $c->code }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $c->nom }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($c->filiere)->nom }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($c->niveau)->code }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($c->salle)->code }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($c->academicYear)->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($c->responsableEnseignant)->prenom }} {{ optional($c->responsableEnseignant)->nom }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a class="text-blue-600 hover:text-blue-900" href="{{ route('classes.show', $c) }}">Voir</a>
                                                <a class="text-green-600 hover:text-green-900" href="{{ route('classes.edit', $c) }}">Modifier</a>
                                                <form action="{{ route('classes.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette classe ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border border-gray-300 px-4 py-8 text-center text-gray-500">Aucune classe</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $classes->links() }}</div>
            </div>
        </main>
    </div>
</div>
@endsection
