@props([
    'grid_df' => 'col-span-4 max-md:col-span-6 max-sm:col-span-12',
])

<!-- У нас 12 колонок -->
<form id="{{ $formid }}" method="POST" enctype="multipart/form-data">
    @csrf
    @foreach($formData['hidden'] as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
    @endforeach
    <div id="edit-content" class="grid grid-cols-12 auto-rows-auto gap-3 {{ $indentStyles  }}">
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput  :elementData="$formData['name']"/>
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select :elementData="$formData['category']"/>
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select :elementData="$formData['topic']"/>
        </div>
        <div class="{{ $grid_df }}">
            <fieldset class="border border-solid border-gray-300 p-2 rounded">
                <legend class="text-sm ml-4">{{ __('core.sizes') }}</legend>
                @error('width')
                    <div class="form-element-errors mb-2">
                        <span class="text-xs text-invalid-value">* {{ $message }}</span>
                    </div>
                @enderror
                @error('height')
                    <div class="form-element-errors mb-2">
                        <span class="text-xs text-invalid-value">* {{ $message }}</span>
                    </div>
                @enderror
                <div class="flex flex-row flex-wrap gap-x-1 gap-y-2">
                    <input class="px-3 py-1 rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                    placeholder:text-gray-600 text-sm" name="width" type="number" min="1" max="10000"
                           value="{{ $formData['width']['value'] }}"
                           placeholder="{{ __('artwork.size.width') }} *">
                    <input class="px-3 py-1  rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                    placeholder:text-gray-600 text-sm" name="height" type="number" min="1" max="10000"
                           value="{{ $formData['height']['value'] }}"
                           placeholder="{{ __('artwork.size.height') }} *">
                    <input class="px-3 py-1 rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                    placeholder:text-gray-600 text-sm" name="depth" type="number" min="1" max="10000"
                           value="{{ $formData['depth']['value'] }}"
                           placeholder="{{ __('artwork.size.depth') }}">
                </div>
            </fieldset>
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput :elementData="$formData['price']"/>
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select :elementData="$formData['created_year']"/>
        </div>
        <div class="col-span-12 w-full">
            <x-shared.form.filepicker :elementData="$formData['images']"/>
        </div>
        <div class="col-span-12 w-full">
            <x-shared.form.textarea :elementData="$formData['description']" />
        </div>

    </div>

    <x-shared.form.submitInput name='go_sort' text="{{ __('artwork.actions.save_and_go_sort') }}" includeMt="{{ true }}" />
    <div class="mt-6"></div>
    <x-shared.form.helper.final-action content="{{ __('artwork.actions.perform_deletion') }}"
                                       deleteText="{{ __('core.delete_creativity') }}"
                                       saveText="{{ __('core.actions.save') }}"
    />
</form>
