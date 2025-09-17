@extends('base')
@section('title', 'Détail personne')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-4xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Détail de la personne #{{ $personne->id }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">Prénom</dt>
                            <dd class="font-semibold">{{ $personne->prenom }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Nom</dt>
                            <dd class="font-semibold">{{ $personne->nom }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Email</dt>
                            <dd class="font-semibold">{{ $personne->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Téléphone</dt>
                            <dd class="font-semibold">{{ $personne->phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Date de naissance</dt>
                            <dd class="font-semibold">{{ $personne->date_naissance }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Lieu de naissance</dt>
                            <dd class="font-semibold">{{ $personne->lieu_naissance }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500 text-sm">Rôle</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @switch($personne->role ?? '')
                                        @case('ADMINISTRATEUR') bg-red-100 text-red-800 @break
                                        @case('ENSEIGNANT')      bg-blue-100 text-blue-800 @break
                                        @case('ETUDIANT')        bg-green-100 text-green-800 @break
                                        @default                 bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ ucfirst(strtolower($personne->role ?? 'invite')) }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    @if($personne->user)
                        <div class="mt-6 p-4 border rounded">
                            <h2 class="font-semibold mb-2">Utilisateur lié</h2>
                            <p class="text-sm text-gray-600">ID utilisateur: {{ $personne->user->id }}</p>
                            <p class="text-sm text-gray-600">Statut: {{ $personne->user->actif ? 'Actif' : 'Inactif' }}</p>
                            <a href="{{ route('users.show', $personne->user) }}" class="text-blue-600 hover:underline">Voir l'utilisateur</a>
                        </div>
                    @endif

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('personnes.edit', $personne) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Modifier</a>
                        <a href="{{ route('personnes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Retour</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
</div>
@endsection

<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
</div>
