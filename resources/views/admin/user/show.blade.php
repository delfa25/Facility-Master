@extends('base')
@section('title', 'Détail utilisateur')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Zone principale -->
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        <!-- Navbar -->
        @include('partials.navbar')

        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-4xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Détail de l'utilisateur #{{ $user->id }}</h1>

                <div class="bg-white rounded-lg shadow p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">Nom complet</dt>
                            <dd class="font-semibold">{{ $user->personne->prenom ?? '' }} {{ $user->personne->nom ?? '' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Email</dt>
                            <dd class="font-semibold">{{ $user->email ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Rôle</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @switch($user->role ?? '')
                                        @case('ADMINISTRATEUR') bg-red-100 text-red-800 @break
                                        @case('ENSEIGNANT')      bg-blue-100 text-blue-800 @break
                                        @case('ETUDIANT')        bg-green-100 text-green-800 @break
                                        @default                 bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ ucfirst(strtolower($user->role ?? 'invite')) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Statut</dt>
                            <dd>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->actif) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $user->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Dernière connexion</dt>
                            <dd class="font-semibold">{{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Jamais connecté' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Modifier</a>
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Retour</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

<div>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</div>
