@extends('base')

@section('title', 'Inscription')

@section('content')

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">

        @if(session('success'))
            <div class="bg-red-100 border border-green-400 text-green-700 px-4 py-3 rounded-relative" role="alert">
                <strong class="font-bold">Success !<strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>    
        @endif

        <form action="{{ route('register.submit') }}" method="post" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="text" id="nom" name="nom" value="{{ old('nom') }}">
                @error('nom')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="text" id="prenom" name="prenom" value="{{ old('prenom') }}">
                @error('prenom')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                @error('date_naissance')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="text" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}">
                @error('lieu_naissance')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="text" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="password" id="password" name="password">
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer votre mot de passe</label>
                <input class="mt-1 p-3 block w-full border border-gray-300 outline-none rounded-md shadow-md" type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-purple-700 hover:bg-purple-500 text-white rounded-md">S'inscrire</button>
            <p class="my-2">
                Deja un compte ?
                <a href="{{ route('login') }}" class="text-red-500">Se connecter des maintenant</a>
            </p>
        </form>

    </div>

@endsection
