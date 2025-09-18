@extends('base')
@section('title', 'Tableau de bord')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('partials.sidebar')
    
    <!-- Zone principale -->
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        <!-- Navbar -->
        @include('partials.navbar')
        
        <!-- Container pour le contenu -->
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Bienvenue sur Facility Master</h1>
                
                <!-- Grid pour vos éléments -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="text-gray-500 text-sm">Total personnes</div>
                        <div class="text-3xl font-bold">{{ $counts['personnes'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="text-gray-500 text-sm">Total étudiants</div>
                        <div class="text-3xl font-bold text-blue-700">{{ $counts['etudiants'] ?? 0 }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="text-gray-500 text-sm">Total enseignants</div>
                        <div class="text-3xl font-bold text-green-700">{{ $counts['enseignants'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection