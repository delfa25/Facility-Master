@extends('base')
@section('title', 'Détail niveau')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Niveau {{ $niveau->code }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">Code</dt>
                            <dd class="font-semibold">{{ $niveau->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Libellé</dt>
                            <dd class="font-semibold">{{ $niveau->libelle }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Ordre</dt>
                            <dd class="font-semibold">{{ $niveau->ordre }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('niveaux.edit', $niveau) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Modifier</a>
                        <a href="{{ route('niveaux.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Retour</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
