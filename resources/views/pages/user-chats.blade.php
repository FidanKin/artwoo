<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Все сообщения</title>
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
<x-layout.standard hasEditSublayout="{{ false }}" bgGray="{{ true }}" :navigationNodes="$navigation">
    <x-layout.secondary.content-base title="Сообщения">
        <x-slot:headerSlot>
            <div class="right-side flex flex-row items-center gap-x-3.5">
{{--                Пока без поиска :( --}}
{{--                <x-shared.lib.base-icon iconurl="icons/block-content.svg" backgroundColor="black" />--}}
{{--                <x-shared.form.search-input searchInputColor="white" inputSize="sm" />--}}
            </div>
        </x-slot:headerSlot>
        <div class="flex flex-col gap-y-4 max-md:flex-row max-md:gap-x-4 max-sm:flex-col">
            @if($isEmpty)
                <p>{{ __("chat.no_chats") }}</p>
            @else
                @foreach($chatMessages as $chatId => $chatMessage)
                    <x-widgets.cards.message-preview
                        chatId="{{ $chatId }}"
                        messagetext="{{ $chatMessage['message']['message'] }}"
                        messagedate="{{ $chatMessage['message']['created_at'] }}"
                        userIconUrl="{{ $chatMessage['to_user']['icon'] }}"
                        userAge="{{ $chatMessage['to_user']['age'] }}"
                        login="{{ $chatMessage['to_user']['login'] }}"
                        userId="{{ $chatMessage['to_user']['id'] }}"
                    />
                @endforeach
            @endif
        </div>
    </x-layout.secondary.content-base>
</x-layout.standard>
</body>
</html>
