@extends('base')
@section('title', 'Modifier une permission')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Modifier la permission {{ $permissions->name }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('permissions.update', $permissions) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input id="name" name="name" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('name', $permissions->name) }}" required>
                            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="pt-2 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('permissions.show', $permissions) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
