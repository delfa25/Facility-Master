@extends('base')
@section('title', 'Accès refusé')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white rounded-lg shadow p-8 text-center">
        <div class="text-red-600 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 mx-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 6h.008v.008H12V18z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-2">Accès refusé (403)</h1>
        <p class="text-gray-600 mb-6">Vous n'avez pas l'autorisation d'accéder à cette page.</p>
        <div class="flex items-center justify-center space-x-3">
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Retour</a>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-600">Aller au tableau de bord</a>
        </div>
    </div>
</div>
@endsection
