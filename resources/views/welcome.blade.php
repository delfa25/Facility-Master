<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100">
        <div class="min-h-screen flex items-center justify-center p-6">
            <div class="text-center space-y-6">
                <h1 class="text-4xl font-extrabold text-gray-900">Facility Master</h1>
                <p class="text-gray-600">Bienvenue</p>

                <div class="flex items-center justify-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-700 text-white rounded-md hover:bg-purple-500">Dashboard</a>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-purple-700 text-white rounded-md hover:bg-purple-500">Log in</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-900 rounded-md border border-gray-300 hover:bg-gray-50">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>