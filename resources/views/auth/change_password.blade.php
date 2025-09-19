@extends('base')

@section('title', 'Changement de mot de passe')

@section('content')

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-6">Changer mon mot de passe</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input id="password" name="password" type="password" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
            </div>

            <div class="pt-2 flex space-x-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-md">
                    Mettre à jour
                </button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
            </div>
        </form>

    </div>

@endsection
