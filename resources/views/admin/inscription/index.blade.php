@extends('base')
@section('title','Reporting des inscriptions')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6 text-center">Reporting des inscriptions</h1>

                <form method="GET" action="{{ route('inscriptions.index') }}" class="flex flex-wrap items-end gap-3 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Recherche</label>
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Nom, prénom, email, classe, année" class="p-2 border rounded w-64">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Classe</label>
                        <select name="classe_id" class="p-2 border rounded w-56">
                            <option value="">Toutes</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ ($classeId ?? '') == $c->id ? 'selected' : '' }}>{{ $c->libelle ?? ($c->code ?? ('Classe #'.$c->id)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Année</label>
                        <select name="annee_id" class="p-2 border rounded w-48">
                            <option value="">Toutes</option>
                            @foreach($annees as $a)
                                <option value="{{ $a->id }}" {{ ($anneeId ?? '') == $a->id ? 'selected' : '' }}>{{ $a->annee ?? ('Année #'.$a->id) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Filtrer</button>
                    </div>
                </form>

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Étudiant</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">INE</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Classe</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Année</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inscriptions as $ins)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ optional($ins->etudiant)->prenom }} {{ optional($ins->etudiant)->nom }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $ins->etudiant->INE ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $ins->classe->libelle ?? ($ins->classe->code ?? ('Classe #'.$ins->classe_id)) }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $ins->anneeAcad->annee ?? ('Année #'.$ins->annee_id) }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ optional($ins->date_inscription)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                            Aucune inscription trouvée
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $inscriptions->links() }}</div>
            </div>
        </main>
    </div>
</div>
@endsection
