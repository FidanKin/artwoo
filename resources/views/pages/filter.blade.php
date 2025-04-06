<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Фильтр контента</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/css/form/autocomplete.css')
</head>
<body class="font-roboto">
<x-layout.standard hasEditSublayout="{{ false }}" bgGray="{{ true }}" >
    <x-layout.secondary.content-base title="Фильтр поиска" isEditable="{{ true }}">
        <x-widgets.artwork-filter />
    </x-layout.secondary.content-base>
</x-layout.standard>
@vite('resources/js/pages/artwork-edit.js')
</body>
</html>
