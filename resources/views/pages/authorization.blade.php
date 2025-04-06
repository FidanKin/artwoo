<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <!-- Fonts -->
    <x-shared.lib.favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body>
<main id="content" class="container mx-auto">
    <x-layout.auth>
        <x-widgets.login :formData="$formData" />
    </x-layout.auth>
</main>
<x-shared.core.front-stack />
@vite('resources/js/app.js')
@vite('resources/js/pages/login.js')
</body>
</html>
