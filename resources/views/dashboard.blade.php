@extends('base')
@section('title', 'Tableau de bord')

@section('content')
<div class="min-h-screen grid grid-cols-[250px_1fr]">
    <!-- Sidebar fixe -->
    <div class="bg-gray-100">
        @include('partials.sidebar')
    </div>
    
    <!-- Zone principale (encadrée en rouge) -->
    <div class="flex flex-col">
        <!-- Navbar -->
        <div class="bg-white shadow-sm">
            @include('partials.navbar')
        </div>
        
        <!-- Contenu principal -->
        <div class="flex-1 p-6 bg-gray-50">
            <h1 class="text-2xl font-bold mb-4">Tableau de bord</h1>
            
            <!-- Vos tableaux et contenu ici -->
            <div class="bg-white rounded-lg shadow p-6">
                <p>Contenu principal - tableaux, cartes, etc.</p>
            </div>
        </div>
    </div>
</div>
@endsection