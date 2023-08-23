<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <title>Laravel 9 TALL</title>

        {{-- Vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Normalización de CSS --}}
        @include('subviews.normalizecss')

        {{-- Estilos Livewire --}}
        @livewireStyles
    </head>

    <body>
        {{-- Layout --}}
        @include('subviews.navbar')
        <main class="p-4">
            {{-- Livewire --}}
            <h1 class="text-base font-bold underline">
                Laravel 9 TALL
            </h1>
        </main>

        {{-- Scripts de livewire --}}
        @livewireScripts
    </body>

</html>
