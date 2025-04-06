<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Личный кабинет</title>
        <!-- Fonts -->
        <x-shared.lib.favicon />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <body class="font-roboto">
        <x-layout.standard hasEditSublayout="{{ true }}" hasfooter="{{ true }}" :navigationNodes="$navigation">
            <x-layout.secondary.edit formId='profile-form'>
                @foreach($formData['hidden'] as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
                @endforeach
                <x-slot:actions>
                    <div class="buttons-area flex flex-row items-center"></div>
                </x-slot:actions>
                @if(!empty($formState))
                    <x-dynamic-component :component="$formState['template_name']" id="alert_form_state_resume" :message="$formState['message']" />
                @endif
                <x-widgets.editProfileInfo :formData="$formData" />
                {{-- Main Content --}}
                <section id="profile-edit-elements">
                    <div class="flex flex-row items-center justify-between pt-6">
                        <x-shared.form.submitInput
                            text="{{ __('core.save_changes') }}"
                            type='submit'
                            name='submit'
                            isFullWidth="{{ false }}"
                        />
                        <x-shared.core.deleteAction id="delete-account"
                                                    content="{{ __('user.actions.confirmation_delete') }}"
                                                    text="{{ __('user.delete_account') }}"
                                                    :url="$actions['delete']" />
                    </div>
                </section>
            </x-layout.secondary.edit>
        </x-layout.standard>
        @vite('resources/js/app.js')
        @vite('resources/js/pages/my-edit.js')
        <x-shared.variables.modal-area />
        <x-shared.core.front-stack />
    </body>
</html>
