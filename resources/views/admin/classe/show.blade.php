@extends('base')
@section('title', 'Détail classe')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-4xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Classe {{ $classe->code }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">Code</dt>
                            <dd class="font-semibold">{{ $classe->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Nom</dt>
                            <dd class="font-semibold">{{ $classe->nom }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Filière</dt>
                            <dd class="font-semibold">{{ optional($classe->filiere)->nom }} ({{ optional($classe->filiere)->code }})</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Niveau</dt>
                            <dd class="font-semibold">{{ optional($classe->niveau)->code }} - {{ optional($classe->niveau)->libelle }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Salle</dt>
                            <dd class="font-semibold">{{ optional($classe->salle)->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Année académique</dt>
                            <dd class="font-semibold">{{ optional($classe->anneeAcad)->code }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500 text-sm">Responsable</dt>
                            <dd class="font-semibold">{{ optional($classe->responsableEnseignant)->prenom }} {{ optional($classe->responsableEnseignant)->nom }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('classes.edit', $classe) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Modifier</a>
                        <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Retour</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
