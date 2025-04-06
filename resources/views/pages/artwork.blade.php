<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Просмотр творческой работы автора</title>
        <x-shared.lib.favicon />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap"
              rel="stylesheet">
        @vite('resources/css/app.css')
        @vite('resources/css/lib/switch.css')
    </head>
    <body class="font-roboto">
        <x-layout.standard bgGray="{{ true }}" :navigationNodes="$navigation">

            @if(!empty($formState))
                <span class="mt-6 block"></span>
                <x-dynamic-component :component="$formState['template_name']" id="alert_form_state_resume" :message="$formState['message']" />
            @endif
            <x-widgets.author-artwork :$author :$artwork :$actions :canEdit="$can_edit" :canSendMessage="$can_send_message" :metaInfo="$meta_info" />
        </x-layout.standard>
    @vite('resources/js/app.js')
    @vite('resources/js/pages/artwork.js')
    <x-shared.variables.modal-area />
    <x-shared.core.front-stack />
    </body>
</html>

