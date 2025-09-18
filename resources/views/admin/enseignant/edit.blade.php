@extends('base')
@section('title', 'Modifier enseignant')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Modifier l'enseignant #{{ $enseignant->id }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('enseignants.update', $enseignant) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                                <input id="grade" name="grade" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('grade', $enseignant->grade) }}">
                                @error('grade')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="specialite" class="block text-sm font-medium text-gray-700">Spécialité</label>
                                <input id="specialite" name="specialite" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('specialite', $enseignant->specialite) }}">
                                @error('specialite')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-4 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('enseignants.show', $enseignant) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
