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
                <h1 class="text-2xl font-bold mb-6 text-center">Liste des utilisateurs</h1>
                @role('SUPERADMIN')
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-700 text-white rounded-md hover:bg-purple-500">
                        + Nouvel utilisateur
                    </a>
                </div>
                @endrole
                <!-- Tableau principal -->
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Rôle</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Statut</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Dernière connexion</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $user->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $user->name ?? '' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $user->email ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                            @switch($user->role ?? '')
                                                @case('ADMINISTRATEUR') bg-red-100 text-red-800 @break
                                                @case('ENSEIGNANT')      bg-blue-100 text-blue-800 @break
                                                @case('ETUDIANT')        bg-green-100 text-green-800 @break
                                                @default                 bg-gray-100 text-gray-800
                                            @endswitch">
                                            {{ ucfirst(strtolower($user->role ?? 'invite')) }}
                                        </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($user->actif) bg-green-100 text-green-800 
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $user->actif ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Jamais connecté' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a class="text-blue-600 hover:text-blue-900" href="{{ route('users.show', $user) }}">
                                                    Voir
                                                </a>
                                                <a href="{{ route('users.edit', $user) }}" 
                                                class="text-green-600 hover:text-green-900">
                                                    Modifier
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" 
                                                    method="POST" 
                                                    class="inline"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                            Aucun utilisateur trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
@endsection