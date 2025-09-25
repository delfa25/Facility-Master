@extends('base')
@section('title', 'Semestres')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Gestion des semestres</h1>

                <div class="flex items-center justify-between mb-4">
                    <form method="GET" action="{{ route('semestres.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher (code, année)" class="p-2 border border-gray-300 rounded w-72">
                        <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
                    </form>
                    <a href="{{ route('semestres.create') }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-600">Créer un semestre</a>
                </div>

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Code</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Année</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Début</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Fin</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($semestres as $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $s->code }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($s->academicYear)->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($s->date_debut)->format('d/m/Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($s->date_fin)->format('d/m/Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a class="text-blue-600 hover:text-blue-900" href="{{ route('semestres.show', $s) }}">Voir</a>
                                                <a class="text-green-600 hover:text-green-900" href="{{ route('semestres.edit', $s) }}">Modifier</a>
                                                <form action="{{ route('semestres.destroy', $s) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce semestre ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-gray-500">Aucun semestre</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $semestres->links() }}</div>
            </div>
        </main>
    </div>
</div>
@endsection
