<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        @vite(['resources/js/app.js'])
    </head>
    <body>
        @include('layouts.navigation')

        @isset($header)
            <div class="bg-light border-bottom">
                <div class="container py-3">
                    {{ $header }}
                </div>
            </div>
        @endisset

        <main class="py-4">
            <div class="container">
                {{ $slot }}
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
