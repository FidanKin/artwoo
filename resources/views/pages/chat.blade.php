<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Чат пользователя</title>
    <x-shared.lib.favicon />
    <!-- Fonts -->
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
    <x-layout.secondary.content-base>
        <x-slot:headerSlot>
            <a href="/chat/">
            <div class="user-info flex flex-row gap-x-5 items-center">
                    <svg width="18" height="31" viewBox="0 0 18 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 2L2 15.5L16 29" stroke="#2666E0" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <x-entity.user.lib.userChat
                            login="{{ $interlocutor['login'] }}"
                            icon="{{ $interlocutor['icon'] }}"
                            status=""
                            messagecount="0"
                    />
            </div>
            </a>
            <div class="right-side flex flex-row items-center gap-x-3.5">
                <x-shared.core.modal-action-icon iconname="delete"
                                                 id="delete-chat"
                                                 title="{{ __('chat.actions.confirm_delete_messages') }}"
                                                 actionUrl="/chat/{{ $chatId }}/delete"
                                                 method="POST"
                                                 actionLabel="{{ __('core.delete') }}"
                                                 closeText="{{ __('core.actions.close') }}"
                >
                    <p> {{ __('chat.actions.perform_delete_messages') }}</p>
                </x-shared.core.modal-action-icon>
            </div>
        </x-slot:headerSlot>
        @if(!empty($formState))
            <x-dynamic-component :component="$formState['template_name']" id="alert_form_state_resume" :message="$formState['message']" />
        @endif

        <x-widgets.cards.single-chat :$messages :$formData toUserId="{{ $interlocutor['id'] }}" />

    </x-layout.secondary.content-base>
</x-layout.standard>
<x-shared.variables.modal-area />
<x-shared.core.front-stack />
@vite('resources/js/pages/single-chat.js')
@vite('resources/js/app.js')
</body>
</html>
