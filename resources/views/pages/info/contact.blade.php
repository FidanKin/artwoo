<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Контакты для связи</title>
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
    <x-layout.secondary.content-base title="{{ __('core.pages.contact.title') }}">
        <div>
            <span class="mb-2 block">{{ __('core.pages.contact.our_contacts_for_help') }}:</span>
            <ul>
                <li>
                    Электронная почта: <a class="text-primaryColor" target="_blank" href="mailto:{{ config('app.admin_email') }}">
                        {{ config('app.admin_email') }}
                    </a>
                </li>
                <li>
                    Telegram: <a class="text-primaryColor" target="_blank" href="{{ config('app.admin_telegram_link') }}">
                        {{ config('app.admin_telegram_username') }}
                    </a>
                </li>
            </ul>
        </div>
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
