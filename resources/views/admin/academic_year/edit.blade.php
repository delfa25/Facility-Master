@extends('base')
@section('title', 'Modifier une année académique')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-3xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Modifier l'année académique</h1>

                <div class="bg-white rounded-lg shadow p-6">
                    <form method="POST" action="{{ route('academic-years.update', $year->id) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="name" value="{{ old('name', $year->name) }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md" placeholder="2024–2025" required>
                            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de début</label>
                                <input type="date" name="start_date" value="{{ old('start_date', optional($year->start_date)->format('Y-m-d')) }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                @error('start_date')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                                <input type="date" name="end_date" value="{{ old('end_date', optional($year->end_date)->format('Y-m-d')) }}" class="mt-1 p-3 w-full border border-gray-300 rounded-md" required>
                                @error('end_date')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="is_current" name="is_current" value="1" class="rounded border-gray-300 text-purple-700 focus:ring-purple-600" {{ old('is_current', $year->is_current) ? 'checked' : '' }}>
                            <label for="is_current" class="text-sm text-gray-700">Définir comme année courante</label>
                            @error('is_current')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="pt-2 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Mettre à jour</button>
                            <a href="{{ route('academic-years.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
