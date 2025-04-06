<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактирование резюме</title>
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
<x-layout.standard hasEditSublayout="{{ false }}" bgGray="{{ true }}" :navigationNodes="$navigation" >
    <x-layout.secondary.content-base>
        <x-slot:headerSlot>
            @if($showWorkplaceButton)
                <x-shared.core.button text="{{ __('resume.actions.add_workplace') }}" padding="sm" buttonID="add-workplace"/>
            @endif
        </x-slot:headerSlot>
        <div id="resume">
            @if(!empty($formState))
                <x-dynamic-component :component="$formState['template_name']" id="alert_form_state_resume" :message="$formState['message']" />
            @endif
            <x-widgets.resume-add-workplace :formData="$formData" />
            <x-widgets.resume-edit-form :formData="$formData" formid="edit-resume" />

            <div id="resume-organizations" class="space-y-6">
                @if(!empty($workplaces))
                    @foreach($workplaces as $workplace)
                        <x-widgets.cards.resume-workplace
                            isEditing="{{ true }}"
                            :title="$workplace->title"
                            :timeworked="$workplace->duration"
                            :description="$workplace->description"
                            :duties="$workplace->duties"
                            :workplaceID="$workplace->id"
                        />
                   @endforeach
                @endif
            </div>
        </div>

    </x-layout.secondary.content-base>
</x-layout.standard>
@vite('resources/js/app.js')
@vite('resources/js/pages/resume-edit.js')
</body>
</html>
