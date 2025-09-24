@extends('base')
@section('title', 'Créer une classe')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Créer une classe</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                                <input id="code" name="code" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('code') }}" required>
                                @error('code')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input id="nom" name="nom" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('nom') }}" required>
                                @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="filiere_id" class="block text-sm font-medium text-gray-700">Filière</label>
                                <select id="filiere_id" name="filiere_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                    <option value="">Sélectionnez</option>
                                    @foreach($filieres as $f)
                                        <option value="{{ $f->id }}" {{ old('filiere_id') == $f->id ? 'selected' : '' }}>{{ $f->nom }} ({{ $f->code }})</option>
                                    @endforeach
                                </select>
                                @error('filiere_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="niveau_id" class="block text-sm font-medium text-gray-700">Niveau</label>
                                <select id="niveau_id" name="niveau_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                    <option value="">Sélectionnez</option>
                                    @foreach($niveaux as $n)
                                        <option value="{{ $n->id }}" {{ old('niveau_id') == $n->id ? 'selected' : '' }}>{{ $n->code }} - {{ $n->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('niveau_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="salle_id" class="block text-sm font-medium text-gray-700">Salle (optionnel)</label>
                                <select id="salle_id" name="salle_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach($salles as $s)
                                        <option value="{{ $s->id }}" {{ old('salle_id') == $s->id ? 'selected' : '' }}>{{ $s->code }} ({{ $s->capacite }})</option>
                                    @endforeach
                                </select>
                                @error('salle_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="annee_id" class="block text-sm font-medium text-gray-700">Année académique (optionnel)</label>
                                <select id="annee_id" name="annee_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach($annees as $a)
                                        <option value="{{ $a->id }}" {{ old('annee_id') == $a->id ? 'selected' : '' }}>{{ $a->code }}</option>
                                    @endforeach
                                </select>
                                @error('annee_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="responsable_enseignant_id" class="block text-sm font-medium text-gray-700">Enseignant responsable (optionnel)</label>
                                <select id="responsable_enseignant_id" name="responsable_enseignant_id" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach($enseignants as $e)
                                        <option value="{{ $e->id }}" {{ old('responsable_enseignant_id') == $e->id ? 'selected' : '' }}>
                                            #{{ $e->id }} - {{ $e->prenom ?? '' }} {{ $e->nom ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('responsable_enseignant_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-2 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
