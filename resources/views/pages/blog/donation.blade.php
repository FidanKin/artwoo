<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Помочь проекту</title>
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
    <a class="text-primaryColor font-bold" href="/blog"> &larr; Все записи блога</a>
    <x-layout.secondary.content-base title="{{ __('core.pages.blog.donation.title') }}" padding="none">
        <article>
            <h3 class="hidden">{{ __('core.pages.blog.donation.title') }}</h3>
            <p class="mb-2">Вы можете поддержать проект, внеся любую сумму по указанному кошельку.
                Все средства пойдут на развитие технического оборудования и функционала
                платформы.</p>
            <p class="mb-2">На данный момент весь проект создается на энтузиазме основателя и
                функционал сайта доступен пользователям абсолютно бесплатно.</p>
            <div>
                <a class="underline font-bold text-primaryColor" href="https://money.alfabank.ru/mr/kJsvbFs2h0">Ссылка для перевода</a>
                <img class="w-90" src="/images/blog/donation_help-project.png" />
            </div>
        </article>
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
