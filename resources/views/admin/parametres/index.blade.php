@extends('base')

@section('title', 'Parametres')

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
                <h1 class="text-2xl font-bold mb-6 text-center">Parametres</h1>

                <div class="ml-10 p-4 grid grid-cols-1 gap-4">
                    <div class="bg-gray-200 rounded-xl shadow-lg p-5 text-center transition-transform transform hover:-translate-y-1 hover:shadow-xl">
                        <div class="card-body"><a href="{{ route('parametres.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 hover:text-black">Parametres</a></div>
                    </div>
                    <div class="bg-gray-200 rounded-xl shadow-lg p-5 text-center transition-transform transform hover:-translate-y-1 hover:shadow-xl">
                        <div class="card-body"><a href="{{ route('parametres.index') }}" class="block px-5 py-2 text-gray-800 hover:bg-gray-200 hover:text-black">Parametres</a></div>
                    </div>
                    <div class="bg-gray-200 rounded-xl shadow-lg p-5 text-center transition-transform transform hover:-translate-y-1 hover:shadow-xl">
                        <div class="card-body"><a href="{{ route('parametres.index') }}" class="block px-5 py-2 text-gray-800 hover:bg-gray-200 hover:text-black">Parametres</a></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
