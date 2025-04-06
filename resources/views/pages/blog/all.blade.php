<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Все запии блога</title>
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
    <x-layout.secondary.content-base title="{{ __('core.pages.blog.all.title') }}" padding="none">
        <ul class="flex flex-col">
            <li>
                <a class="text-primaryColor font-bold" href="/blog/about">{{ __('core.pages.blog.about.title') }}</a>
            </li>
            <li>
                <a class="text-primaryColor font-bold" href="/blog/founders">{{ __('core.pages.blog.founders.title') }}</a>
            </li>
            <li>
                <a class="text-primaryColor font-bold" href="/blog/donation">{{ __('core.pages.blog.donation.title') }}</a>
            </li>
            <li>
                <a class="text-primaryColor font-bold" href="/blog/feedback">{{ __('core.pages.blog.feedback.title') }}</a>
            </li>
        </ul>
        <div class="mt-4">
            <img class="rounded max-w-2xl w-full" src="/images/blog-all.jpg" />
        </div>
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
