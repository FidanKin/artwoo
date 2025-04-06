<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Обратная связь</title>
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
    <x-layout.secondary.content-base title="{{ __('core.pages.blog.feedback.title') }}" padding="none">
        <article>
            <h3 class="hidden">{{ __('core.pages.blog.feedback.title') }}</h3>
            <div>
                Для заполнения формы обратной связи кликните по <x-shared.core.link size="big" color="primary"
                    text="ссылке" url="https://forms.yandex.ru/cloud/6728f6b484227c796ef9ccb7/" underline="{{ true }}" />
                <img src="/images/blog/feedback_add-answer.png" alt="Обратная связь" />
            </div>
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
