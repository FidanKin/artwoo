<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Страница референсов папки "{{ $folder->name }}"</title>
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
<x-layout.standard hasEditSublayout="{{ false }}" :navigationNodes="$navigation">
    <x-layout.secondary.content-base>
        <x-slot:headerSlot>
            <a href="/reference">
                <div class="flex flex-row items-center gap-x-5">
                    <svg width="18" height="31" viewBox="0 0 18 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 2L2 15.5L16 29" stroke="#2666E0" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h2 class="font-bold text-h4 inline">{{ $folder->name }} / {{ $folderCountRefs }}</h2>
                </div>
            </a>
            <div class="right-side flex flex-row items-center gap-x-3.5">
                <x-shared.form.search-input inputSize="sm" enablefilter="{{ false }}" :$searches />
                <x-shared.core.modal-action-icon iconname="delete"
                                                 id="delete-folder"
                                                 title="{{ __('reference.actions.delete_folder') }}"
                                                 actionUrl="/reference/folder/delete/{{ $folder->id }}"
                                                 method="POST"
                                                 actionLabel="{{ __('reference.actions.confirm_delete_folder') }}"
                                                 closeText="{{ __('core.actions.close') }}"
                >
                    <p> {{ __('reference.actions.delete_folder_description') }}</p>
                </x-shared.core.modal-action-icon>
            </div>
        </x-slot:headerSlot>

        @if(!empty($formState))
            <x-dynamic-component :component="$formState['template_name']" id="alert_form_state_resume" :message="$formState['message']" />
        @endif

        <div class="add-references mb-4 flex flex-row justify-center">
            <x-shared.core.modal-action      id="add-references-to-folder"
                                             text="{{ __('reference.actions.add_references') }}"
                                             title="{{ __('reference.actions.upload_references') }}"
                                             actionUrl=""
                                             method=""
                                             actionLabel=""
                                             closeText=""
            >
                <form id="add-references" method="POST" enctype="multipart/form-data" action="/reference/folder/{{ $folder->id }}">
                    @csrf
                    <x-shared.form.filepicker :elementData="$formData['add-references']"/>
                    <div class="w-100 mt-3">
                        <x-shared.form.submit-input name="submit" text="{{ __('core.actions.save') }}" />
                    </div>
                </form>

            </x-shared.core.modal-action>
        </div>

        <div class="folder-description pb-4">
            @if(!empty($folder->description))
                <h3 class="text-slate-500 text-lg">{{ __('reference.description') }}:</h3>
                <p>{{ $folder->description }}</p>
            @endif
        </div>

        <div class="reference-collection">
            <div class="">
                @if(empty($paginator->mutationEntity))
                    <p class="text-center w-full"> {{ __('reference.reference_not_uploaded') }} :( </p>
                @else
                    <div class="justify-center grid grid-cols-3 gap-4 max-md:grid-cols-2 max-sm:grid-cols-1 max-sm:place-items-center">
                        @foreach($paginator->mutationEntity as $reference)
                            <x-widgets.cards.reference-image :$reference displayActions="{{ true }}" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{ $paginator->model->links() }}

    </x-layout.secondary.content-base>
</x-layout.standard>
<x-shared.variables.modal-area />
@vite('resources/js/pages/reference-folder.js')
@vite('resources/js/app.js')
<x-shared.core.front-stack />
</body>
</html>
