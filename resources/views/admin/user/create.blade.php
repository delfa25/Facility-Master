@extends('base')
@section('title', 'Créer un utilisateur')
@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Créer un utilisateur</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('users.store') }}" method="POST" id="user-form" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type (rôle)</label>
                                <select name="role" id="role" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                    <option value="">Sélectionnez</option>
                                    @foreach($roles as $r)
                                        <option value="{{ $r }}" {{ old('role')===$r ? 'selected' : '' }}>{{ $r }}</option>
                                    @endforeach
                                </select>
                                @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                                <input type="password" name="password" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <h2 class="text-lg font-semibold">Informations communes</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="nom" value="{{ old('nom') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" name="prenom" value="{{ old('prenom') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                @error('prenom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Adresse</label>
                                <input type="text" name="adresse" value="{{ old('adresse') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div id="bloc-etudiant" class="hidden border-t pt-4">
                            <h3 class="font-semibold mb-2">Informations Étudiant</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">INE</label>
                                    <div class="mt-2 text-gray-600 text-sm">L'INE sera généré automatiquement lors de l'enregistrement.</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date d'inscription</label>
                                    <input type="date" name="date_inscription" value="{{ old('date_inscription') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Statut</label>
                                    <select name="statut_etudiant" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                        <option value="">--</option>
                                        @foreach(['INACTIF','ACTIF','SUSPENDU','DIPLOME'] as $s)
                                            <option value="{{ $s }}" {{ old('statut_etudiant')===$s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="bloc-enseignant" class="hidden border-t pt-4">
                            <h3 class="font-semibold mb-2">Informations Enseignant</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Grade</label>
                                    <input type="text" name="grade" value="{{ old('grade') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Spécialité</label>
                                    <input type="text" name="specialite" value="{{ old('specialite') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Statut</label>
                                    <select name="statut_enseignant" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                        <option value="">--</option>
                                        @foreach(['INACTIF','SUSPENDU','ACTIF'] as $s)
                                            <option value="{{ $s }}" {{ old('statut_enseignant')===$s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="bloc-admin" class="hidden border-t pt-4">
                            <h3 class="font-semibold mb-2">Informations Admin</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Bureau</label>
                                    <input type="text" name="bureau" value="{{ old('bureau') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleBlocks() {
    const v = document.getElementById('role').value;
    const show = id => document.getElementById(id).classList.remove('hidden');
    const hide = id => document.getElementById(id).classList.add('hidden');
    ['bloc-etudiant','bloc-enseignant','bloc-admin'].forEach(hide);
    if (v === 'ETUDIANT') show('bloc-etudiant');
    if (v === 'ENSEIGNANT') show('bloc-enseignant');
    if (v === 'ADMINISTRATEUR') show('bloc-admin');
}
document.addEventListener('DOMContentLoaded', () => {
    const roleEl = document.getElementById('role');
    if (roleEl) {
        roleEl.addEventListener('change', toggleBlocks);
        toggleBlocks();
    }
});
</script>
@endsection
