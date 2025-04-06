<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Страница всех референсов</title>
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
    <x-layout.secondary.content-base>
        <x-slot:headerSlot>
            <h2 class="font-bold text-h4 inline">Референсы</h2>
            <div class="right-side flex flex-row items-center gap-x-3.5 max-sm:flex-col max-sm:gap-y-2.5">
                <x-shared.form.search-input searchInputColor="white" inputSize="sm" enablefilter="{{ false }}" :$searches />
                <x-shared.core.modal-action id="create-folder-action" method="" title="{{ __('reference.create_folder_form') }}" text="{{ __('reference.create_folder') }}" actionUrl="" actionLabel="" closeText="">
                    <form id="create-folder" action="/reference/folder" method="POST">
                        @csrf
                        <x-widgets.reference-folder-create :$formData/>
                    </form>
                </x-shared.core.modal-action>
            </div>
        </x-slot:headerSlot>
        @if(!empty($formState))
            <x-dynamic-component :component="$formState['template_name']" id="alert_form_state_resume" :message="$formState['message']" />
        @endif
        <div id="ref-folders" class="pb-4">
            <div class="ref-folders flex flex-row flex-wrap gap-x-4 mb-9 gap-y-6 justify-center">
                @if(!empty($folders))
                    @foreach($folders as $folder)
                        <a href="/reference/folder/{{ $folder['id'] }}">
                            <x-widgets.cards.reference-folder name="{{ $folder['name'] }}" />
                        </a>
                    @endforeach

                @else
                    <p> {{ __('reference.folder_empty') }}</p>
                @endif
            </div>
            <x-shared.lib.divider />
        </div>

        <div class="top-references mt-2">
            @if(!empty($references->mutationEntity))
                <div class="flex flex-row flex-wrap justify-center">
                    @foreach($references->mutationEntity as $reference)
                        <x-widgets.cards.reference-image :$reference displayActions="{{ false }}" />
                    @endforeach
                </div>
                {{ $references->model->links() }}
            @endif
        </div>

    </x-layout.secondary.content-base>
</x-layout.standard>
<x-shared.variables.modal-area />

@vite('resources/js/pages/references.js')
@vite('resources/js/app.js')
<x-shared.core.front-stack />
</body>
</html>
