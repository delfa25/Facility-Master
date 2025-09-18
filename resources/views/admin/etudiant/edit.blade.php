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
                    <form action="{{ route('etudiants.update', $etudiant) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

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
