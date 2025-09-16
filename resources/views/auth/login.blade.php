@extends('base')

@section('title', 'Se connecter')

@section('content')

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-relative" role="alert">
                <strong class="font-bold">Erreur !<strong>
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>    
        @endif

        <form action="{{ route('login.submit') }}" method="post" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input class="mt-1 p-3 block w-full border vorder-gray-300 outline-none rounded-md shadow-md" type="password" id="password" name="password" value="{{ old('password') }}">
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>
            </div><br>
            <button type="submit" class="w-full py-2 px-4 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Se connecter</button>
        </form>

    </div>

@endsection
