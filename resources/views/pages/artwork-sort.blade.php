<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Интерфейс указания порядка отображения изображений</title>
    <!-- Fonts -->
    <x-shared.lib.favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-roboto">
    <x-layout.standard bgGray="{{ true }}" :navigationNodes="$navigation">
        <x-layout.secondary.content-base title="{{ __('artwork.sort_title') }}">
            <div id="sort-desc" class="mb-4 mt-2">
                <div class="flex flex-row gap-x-4">
                    <img src="/icons/attention.svg" />
                    <p class="text-strong-gray">{{ __('artwork.sort_desc') }}</p>
                </div>
            </div>
            <div id="artwork-images" class="grid grid-cols-4 gap-4 max-md:grid-cols-2 max-mm:grid-cols-1">
                    @foreach ($artworkImages as $image)
                        <a class="artwork-image-full max-md:mx-auto" href="{{ $image }}">
                            <img class="w-64 h-64 object-cover rounded" src="{{ $image }}" alt="alt"/>
                        </a>
                    @endforeach
            </div>
            <form id="sortable-artworks" name="sortable" method="POST" action="/artwork/sort/{{ $artworkId }}">
                @csrf
                <input id="sort-input" name="sorting" type="hidden" value="" />
                <x-shared.form.submitInput name='submit' text="{{ __('core.actions.save') }}" includeMt="{{ true }}" />
            </form>
        </x-layout.secondary.content-base>
    </x-layout.standard >

<x-shared.variables.modal-area />
@vite('resources/js/app.js')
@vite('resources/js/pages/artwork-sort.js')
<x-shared.core.front-stack />
</body>
</html>
