@extends('base')
@section('title', 'Modifier personne')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Modifier la personne #{{ $personne->id }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('personnes.update', $personne) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input id="prenom" name="prenom" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('prenom', $personne->prenom) }}">
                                @error('prenom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input id="nom" name="nom" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('nom', $personne->nom) }}">
                                @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('email', $personne->email) }}">
                                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input id="phone" name="phone" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('phone', $personne->phone) }}">
                                @error('phone')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                <input id="date_naissance" name="date_naissance" type="date" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('date_naissance', optional($personne->date_naissance)->format('Y-m-d')) }}">
                                @error('date_naissance')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                                <input id="lieu_naissance" name="lieu_naissance" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('lieu_naissance', $personne->lieu_naissance) }}">
                                @error('lieu_naissance')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                                <select id="role" name="role" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ old('role', $personne->role) === $role ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-4 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('personnes.show', $personne) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
</div>
