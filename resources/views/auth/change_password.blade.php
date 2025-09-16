@extends('base')

@section('title', 'Changement de mot de passe')

@section('content')

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">

        @if(session('success'))
            <div class="bg-red-100 border border-green-400 text-green-700 px-4 py-3 rounded-relative" role="alert">
                <strong class="font-bold">Success !<strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>    
        @endif

        <form action="{{ route('password.change.submit') }}" method="post" class="mt-6">
            @csrf
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
            <button type="submit" class="w-full py-2 px-4 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Confirmer</button>
        </form>

    </div>

@endsection
