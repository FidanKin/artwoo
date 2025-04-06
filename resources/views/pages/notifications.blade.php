<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Интерфейс просмотра уведомлений</title>
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
    <x-layout.secondary.content-base>
        <x-slot:headerSlot>
            <div class="flex flex-row gap-x-1.5 items-center">
                @php
                    $messagecount = 8;
                @endphp
                <h2 class="font-bold text-h4 inline">Уведомления</h2>
                <div class="message-counter w-[25px] h-[25px] bg-primaryColor
                rounded-full text-white relative">
                    <span class="text-base font-bold absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        {{ $messagecount }}
                    </span>
                </div>
            </div>
            <x-shared.core.button text="Очистить уведомления" padding="sm" backgroundColor="black"/>
        </x-slot:headerSlot>

        @php
            $title = "Один из ваших откликов отметили как спам";
            $description = "Возможно, это ошибка, но мы рекомендуем прочитать материал, какие отклики нравятся
            заказчикам, чтобы повысить шансы на получение заказа и избежать повторения подобных ситуаций в будущем.";
            $datetext = "01.06.2022";
        @endphp
        <div class="space-y-4 pb-2">
            <x-widgets.cards.notification :title="$title" :description="$description" :datetext="$datetext" />
            <x-widgets.cards.notification :title="$title" :description="$description" :datetext="$datetext" />
            <x-widgets.cards.notification :title="$title" :description="$description" :datetext="$datetext" />
        </div>
        <x-shared.core.load-content darkBg="{{ true }}" />
    </x-layout.secondary.content-base>
</x-layout.standard>
@vite('resources/js/pages/artwork-edit.js')
</body>
</html>
