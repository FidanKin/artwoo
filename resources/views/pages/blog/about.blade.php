<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>О платформе Artwoo.ru</title>
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
    <x-layout.secondary.content-base title="{{ __('core.pages.blog.about.title') }}" padding="none">
        <article class="mb-4">
        <h3 class="hidden">{{ __('core.pages.blog.about.title') }}</h3>
        <p class="mb-2">{{ config('app.domain') }} – это платформа для творческих людей: художников, скульптуров и
        хендмейщиков. Наша задача состоит в том, чтобы вы могли свободно
        размещать все свои работы, продавать их, сохранять источники вдохновения,
        публиковать резюме и общаться с другими участниками и всё это в одном месте.</p>
        <p class="mb-2">В отличие от других платформ, мы не берем плату за размещение работ.
            Здесь вы можете свободно размещать контент бесплатно.</p>
        <p class="mb-2">Также платформа развивается на основе ваших отзывов (отзывов
        пользователей), функционал платформы задают пользователи. Если у тебя
        есть идеи, какое улучшение стоит внедрить, то ты можешь написать нам и
        мы обсудим это (бесплатно). Мы полностью заинтересованы в том, чтобы
        пользователи задавали ход развития.</p>
        <p class="mb-2">Надеемся, что {{ config('app.domain') }} поможет вам в творческом развитии и вы сможете
        зарабатывать на своей деятельности.</p>
        <p class="mb-2">Коротко об основателях:</p>
        <p class="mb-2">Основательница проекта – {{ config('app.founder_liliya') }}. Весь
        функционал продуман именно ей.</p>
        <div class="max-w-2xl my-4">
            <img class="rounded" src="/images/blog/about_liliya-main-photo.jpg" />
        </div>
        <p class="mb-2">Главный разработчик – {{ config('app.founder_fidan') }}.</p>
        <div class="max-w-2xl my-4">
            <img class="rounded" src="/images/blog/about_fidan-main-photo.jpg"/>
        </div>
        <p>
            Более подробная информация об основателях находится <a class="text-primaryColor" href="/blog/founders">здесь</a>.
        </p>
        </article>
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
