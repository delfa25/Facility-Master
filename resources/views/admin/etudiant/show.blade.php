@extends('base')
@section('title', 'Détail étudiant')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-4xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Étudiant #{{ $etudiant->id }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">INE</dt>
                            <dd class="font-semibold">{{ $etudiant->INE }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Nom complet</dt>
                            <dd class="font-semibold">{{ $etudiant->personne->prenom ?? '' }} {{ $etudiant->personne->nom ?? '' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Statut</dt>
                            <dd>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($etudiant->statut === 'Actif') bg-green-100 text-green-800 
                                    @elseif($etudiant->statut === 'INACTIF') bg-gray-100 text-gray-800 
                                    @elseif($etudiant->statut === 'Suspendu') bg-yellow-100 text-yellow-800 
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $etudiant->statut }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Date d'inscription</dt>
                            <dd class="font-semibold">{{ $etudiant->date_inscription ? $etudiant->date_inscription->format('d/m/Y') : '-' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('etudiants.edit', $etudiant) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Modifier</a>
                        <a href="{{ route('etudiants.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Retour</a>
                        @if($etudiant->statut !== 'Actif')
                            <form action="{{ route('etudiants.inscrire', $etudiant) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Inscrire l'étudiant</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
