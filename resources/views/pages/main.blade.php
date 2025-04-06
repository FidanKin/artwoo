<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Все работы авторов сайта Artwoo.ru</title>
        <!-- Fonts -->
        <x-shared.lib.favicon />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body>
        <x-layout.standard>
            <x-shared.form.search-input :$searches />
            <x-layout.secondary.content-base title="{{ __('core.main_page') }}">
                <div id="artwork-topic-tags" class="mb-3.5 h-auto">
                    <x-shared.lib.collections.tags :taglist="$tags" cleanQuery="/" />
                </div>
                <x-widgets.collections.artwork :$items />
                {{ $pagination->withQueryString()->links() }}
            </x-layout.secondary.content-base>
        </x-layout.standard>
    </body>
    <x-shared.variables.modal-area />
    <x-shared.core.front-stack />
    @vite('resources/js/pages/main.js')
</html>
