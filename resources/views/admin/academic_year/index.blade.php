@extends('base')
@section('title', 'Années académiques')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-6xl ml-[250px]">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold">Années académiques</h1>
                    <a href="{{ route('academic-years.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-700 text-white rounded-md hover:bg-purple-500">Créer</a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
                @endif

                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Début</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Fin</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Courante</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($years as $year)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $year->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $year->start_date?->format('d/m/Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $year->end_date?->format('d/m/Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if($year->is_current)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Oui</span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Non</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('academic-years.edit', $year->id) }}" class="text-blue-600 hover:text-blue-800">Modifier</a>
                                                <form action="{{ route('academic-years.destroy', $year->id) }}" method="POST" onsubmit="return confirm('Supprimer cette année académique ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-gray-500">Aucune année académique</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">{{ $years->links() }}</div>
            </div>
        </main>
    </div>
</div>
@endsection
