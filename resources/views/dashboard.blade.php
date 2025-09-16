@extends('base')
@section('title', 'Tableau de bord')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('partials.sidebar')
    
    <!-- Zone principale -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        @include('partials.navbar')
        
        <!-- Container pour le contenu -->
        <main class="flex-1 p-6 overflow-auto">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">Tableau de bord</h1>
                
                <!-- Grid pour vos éléments -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold">Carte 1</h3>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold">Carte 2</h3>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold">Carte 3</h3>
                    </div>
                </div>
                
                <!-- Tableau principal -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-4">Données principales</h2>
                        <table class="w-full">
                            <!-- Votre tableau ici -->
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection