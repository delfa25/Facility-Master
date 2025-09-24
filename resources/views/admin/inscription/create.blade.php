@extends('base')
@section('title', 'Nouvelle inscription')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Inscrire l'étudiant {{ $etudiant->prenom ?? '' }} {{ $etudiant->nom ?? '' }} (INE {{ $etudiant->INE }})</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('inscriptions.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="classe_id" class="block text-sm font-medium text-gray-700">Classe</label>
                                <select id="classe_id" name="classe_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                    <option value="">Sélectionnez une classe</option>
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}" {{ old('classe_id') == $c->id ? 'selected' : '' }}>{{ $c->libelle ?? ($c->code ?? ('Classe #'.$c->id)) }}</option>
                                    @endforeach
                                </select>
                                @error('classe_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="annee_id" class="block text-sm font-medium text-gray-700">Année académique</label>
                                <select id="annee_id" name="annee_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                    <option value="">Sélectionnez une année</option>
                                    @foreach($annees as $a)
                                        <option value="{{ $a->id }}" {{ old('annee_id') == $a->id ? 'selected' : '' }}>{{ $a->annee ?? ('Année #'.$a->id) }}</option>
                                    @endforeach
                                </select>
                                @error('annee_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="date_inscription" class="block text-sm font-medium text-gray-700">Date d'inscription</label>
                                <input id="date_inscription" name="date_inscription" type="date" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('date_inscription', now()->format('Y-m-d')) }}">
                                @error('date_inscription')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-4 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-blue-700 hover:bg-blue-500 text-white rounded-md">Valider l'inscription</button>
                            <a href="{{ route('etudiants.show', $etudiant) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
