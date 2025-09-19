@extends('base')
@section('title', 'Modifier étudiant')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Modifier l'étudiant #{{ $etudiant->id }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('etudiants.update', $etudiant) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <h2 class="text-lg font-semibold">Informations Personne</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input id="nom" name="nom" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('nom', optional($etudiant->personne)->nom) }}">
                                @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input id="prenom" name="prenom" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('prenom', optional($etudiant->personne)->prenom) }}">
                                @error('prenom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                <input id="date_naissance" name="date_naissance" type="date" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('date_naissance', optional(optional($etudiant->personne)->date_naissance)->format('Y-m-d')) }}">
                                @error('date_naissance')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                                <input id="lieu_naissance" name="lieu_naissance" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('lieu_naissance', optional($etudiant->personne)->lieu_naissance) }}">
                                @error('lieu_naissance')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('email', optional($etudiant->personne)->email) }}">
                                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input id="phone" name="phone" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('phone', optional($etudiant->personne)->phone) }}">
                                @error('phone')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <h2 class="text-lg font-semibold pt-2">Informations Étudiant</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="INE" class="block text-sm font-medium text-gray-700">INE</label>
                                <input id="INE" name="INE" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('INE', $etudiant->INE) }}">
                                @error('INE')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select id="statut" name="statut" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                    @foreach($statuts as $s)
                                        <option value="{{ $s }}" {{ old('statut', $etudiant->statut) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('statut')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="date_inscription" class="block text-sm font-medium text-gray-700">Date d'inscription</label>
                                <input id="date_inscription" name="date_inscription" type="date" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('date_inscription', optional($etudiant->date_inscription)->format('Y-m-d')) }}">
                                @error('date_inscription')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-4 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('etudiants.show', $etudiant) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
