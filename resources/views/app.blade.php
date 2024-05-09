<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @if (env('APP_EVENTO') == 'pastelitos')
            <link rel="shortcut icon" href="{{ asset('images/logo-unidad.png') }}" type="image/x-icon">
        @else
            <link rel="shortcut icon" href="{{ asset('images/rover-logo.png') }}" type="image/x-icon">
        @endif
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/rover-logo.png') }}">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased" style="background-color: #1f2937;">
        @inertia
    </body>
</html>
