@extends('base')
@section('title', 'Modifier un profil')

@section('content')
<div class="min-h-screen flex">
    @include('partials.sidebar')
    <div class="flex-1 flex flex-col pl-6 pr-4 py-2">
        @include('partials.navbar')
        <main class="flex-1 p-6 items-center overflow-auto">
            <div class="max-w-2xl ml-[250px]">
                <h1 class="text-2xl font-bold mb-6">Modifier le profil {{ $role->name }}</h1>
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('roles.update', $role) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input id="name" name="name" type="text" class="mt-1 p-3 w-full border border-gray-300 rounded-md" value="{{ old('name', $role->name) }}" required>
                            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                            <div class="space-y-4">
                                @foreach($groupedPermissions as $group => $items)
                                    <div x-data>
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $group }}</h3>
                                            <div class="space-x-2">
                                                <button type="button" class="text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300"
                                                    @click="$root.querySelectorAll('[data-group={{ Str::slug($group) }}] input[type=checkbox]').forEach(cb => cb.checked = true)">
                                                    Tout sélectionner
                                                </button>
                                                <button type="button" class="text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300"
                                                    @click="$root.querySelectorAll('[data-group={{ Str::slug($group) }}] input[type=checkbox]').forEach(cb => cb.checked = false)">
                                                    Tout désélectionner
                                                </button>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" data-group="{{ Str::slug($group) }}">
                                            @foreach($items as $perm)
                                                <label class="inline-flex items-center space-x-2 p-2 rounded border border-gray-200 hover:bg-gray-50">
                                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="rounded border-gray-300 text-purple-700 focus:ring-purple-600"
                                                        {{ in_array($perm->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-700">{{ $perm->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-2 flex space-x-3">
                            <button type="submit" class="px-4 py-2 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Enregistrer</button>
                            <a href="{{ route('roles.show', $role) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
