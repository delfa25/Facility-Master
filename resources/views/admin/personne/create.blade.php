@extends('base')

@section('title', 'Personne - Inscription')

@section('content')

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-relative" role="alert">
                <strong class="font-bold">Success !<strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>    
        @endif

        <form action="{{ route('personne.submit') }}" method="post" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="text" id="nom" name="nom" value="{{ old('nom') }}">
                @error('nom')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prenom</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="text" id="prenom" name="prenom" value="{{ old('prenom') }}">
                @error('prenom')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de  naissance</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                @error('date_naissance')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="text" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}">
                @error('lieu_naissance')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Telephone</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="text" id="phone" name="phone" value="{{ old('phone') }}" pattern="^\+\d{1,3}(\s?\d{1,14})$" title="Format attendu : +Indicatif Numéro (ex: +226 70123456)">
                @error('phone')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select id="role" name="role" class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md">
                    <option value="INVITE" {{ old('role') === 'INVITE' ? 'selected' : '' }}>INVITE</option>
                    <option value="ETUDIANT" {{ old('role') === 'ETUDIANT' ? 'selected' : '' }}>ETUDIANT</option>
                    <option value="ENSEIGNANT" {{ old('role') === 'ENSEIGNANT' ? 'selected' : '' }}>ENSEIGNANT</option>
                    <option value="ADMINISTRATEUR" {{ old('role') === 'ADMINISTRATEUR' ? 'selected' : '' }}>ADMINISTRATEUR</option>
                </select>
                @error('role')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Valider</button>
            <a href="{{ route('personnes.index') }}" class="mt-3 block w-full text-center py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">Retour</a>
        </form>
        
    </div>

@endsection
