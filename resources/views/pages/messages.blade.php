<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Список всех сообщений</title>
    <!-- Fonts -->
    <x-shared.lib.favicon />
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
    <x-layout.secondary.content-base title='Сообщения'>
        <x-slot:headerSlot>
            <div class="right-side flex flex-row items-center gap-x-3.5">
                <x-shared.lib.base-icon iconurl="icons/block-content.svg" backgroundColor="black" />
                <x-shared.form.search-input searchInputColor="white" inputSize="sm" />
            </div>
        </x-slot:headerSlot>
        <div class="space-y-4">
            @for($i = 0; $i < 3; $i++)
                <x-widgets.cards.message-preview
                    messagetext="В год 150-летия Сергея Рахманинова знаменитая опера не менее известного композитора звучит"
                    messagedate="01.06.2022"
                    messsagecount="{{ 6 }}"
                />
            @endfor
        </div>
        <x-shared.core.load-content darkBg="{{ true }}" />
    </x-layout.secondary.content-base>
</x-layout.standard>
@vite('resources/js/pages/artwork-edit.js')
</body>
</html>
