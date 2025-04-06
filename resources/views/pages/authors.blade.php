
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Все авторы сайта Artwoo.ru</title>
    <!-- Fonts -->
    <x-shared.lib.favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/css/lib/switch.css')
    @vite('resources/js/app.js')
</head>
<body class="font-roboto">
<x-layout.standard bgGray="{{ true }}" :navigationNodes="$navigation">
    <x-layout.secondary.content-base title="Авторы работ / {{ $quantity }}">
        <x-slot:headerSlot>
            <x-shared.form.search-input searchInputColor="white" enablefilter="{{ false }}" :$searches />
        </x-slot:headerSlot>
        <div class="space-y-3.5 pb-5">
            @foreach($authors as $authorId => $authorData)
                <x-widgets.cards.author :author="$authorData['author']" :artworks="$authorData['artwork']" />
            @endforeach
        </div>
        {{ $paginator->links() }}
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
