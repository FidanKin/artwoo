@props([
    'grid_df' => 'col-span-4 max-md:col-span-6 max-sm:col-span-12',
    'component_enabled' => old('number_components') && old('has_components'),
    'has_size' => count($formData['size']) > 0,
    'size' => $formData['size']
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

        <div class="{{ $grid_df }} {{ ($component_enabled || count($size) > 1) ? 'hidden' : '' }}" data-input="size">
            <fieldset class="border border-solid border-gray-300 p-2 rounded">
                <legend class="text-sm ml-4">{{ __('core.sizes') }}</legend>

                @if(! $component_enabled)
                    @if($errors->has('width.*'))
                        @foreach($errors->get('width.*') as $error)
                            @foreach($error as $message)
                                <div class="form-element-errors mb-2">
                                    <span class="text-xs text-invalid-value">* {{ $message }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    @endif

                    @if($errors->has('height.*'))
                        @foreach($errors->get('height.*') as $error)
                            @foreach($error as $message)
                                <div class="form-element-errors mb-2">
                                    <span class="text-xs text-invalid-value">* {{ $message }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    @endif

                    @if($errors->has('depth.*'))
                        @foreach($errors->get('depth.*') as $error)
                            @foreach($error as $message)
                                <div class="form-element-errors mb-2">
                                    <span class="text-xs text-invalid-value">* {{ $message }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                @endif

                <div class="flex flex-row flex-wrap gap-x-1 gap-y-2">
                    <input class="px-3 py-1 rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                placeholder:text-gray-600 text-sm" name="width[]" type="number" min="0" max="10000"
                           value="{{ $size[0]['width'] ?? '' }}"
                           placeholder="{{ __('artwork.size.width') }} *"
                           step="0.1"
                           @disabled($component_enabled) >
                    <input class="px-3 py-1  rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                placeholder:text-gray-600 text-sm" name="height[]" type="number" min="0" max="10000"
                           value="{{ $size[0]['height'] ?? '' }}"
                           placeholder="{{ __('artwork.size.height') }} *"
                           step="0.1"
                           @disabled($component_enabled) >
                    <input class="px-3 py-1 rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                placeholder:text-gray-600 text-sm" name="depth[]" type="number" min="0" max="10000"
                           value="{{ $size[0]['depth'] ?? '' }}"
                           placeholder="{{ __('artwork.size.depth') }}"
                           step="0.1"
                           @disabled($component_enabled) >
                </div>
            </fieldset>
        </div>

        <div class="{{ $grid_df }}">
            <x-shared.form.textInput :elementData="$formData['price']"/>
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select :elementData="$formData['created_year']"/>
        </div>
        <div class="col-span-12 w-full" data-input="has_components">
            <x-shared.form.checkbox :elementData="$formData['has_components']" bgwhite="{{ true }}"/>
        </div>
        <div class="col-span-12 w-full {{ (old('has_components') || count($size) > 1) ? '' : 'hidden' }}" data-input="number_components">
            <x-shared.form.select :elementData="$formData['number_components']"/>
        </div>
        <div class="{{ $grid_df }} {{$component_enabled || $has_size ? '' : 'hidden'}}"
             data-input="component_sizes">
            @if($component_enabled || count($formData['size']) > 1)
                @foreach($formData['size'] as $i => $size)
                    <fieldset class="border border-solid border-gray-300 p-2 rounded">
                    <legend class="text-sm ml-4">{{ __('core.sizes') }}</legend>
                    @if($errors->has('width.' . $i))
                        @foreach($errors->get('width.' . $i) as $message)
                            <div class="form-element-errors mb-2">
                                <span class="text-xs text-invalid-value">* {{ $message }}</span>
                            </div>
                        @endforeach
                    @endif
                    @if($errors->has('height.' . $i))
                        @foreach($errors->get('height.' . $i) as $message)
                            <div class="form-element-errors mb-2">
                                <span class="text-xs text-invalid-value">* {{ $message }}</span>
                            </div>
                        @endforeach
                    @endif
                    @if($errors->has('depth.' . $i))
                        @foreach($errors->get('depth.' . $i) as $message)
                            <div class="form-element-errors mb-2">
                                <span class="text-xs text-invalid-value">* {{ $message }}</span>
                            </div>
                        @endforeach
                    @endif
                    <div class="flex flex-row flex-wrap gap-x-1 gap-y-2">
                        <input class="px-3 py-1 rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                    placeholder:text-gray-600 text-sm" name="width[{{ $i }}]" type="number" min="0" max="10000"
                               value="{{ $size['width'] }}"
                               step="0.1"
                               placeholder="{{ __('artwork.size.width') }} *">
                        <input class="px-3 py-1  rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                    placeholder:text-gray-600 text-sm" name="height[{{ $i }}]" type="number" min="0" max="10000"
                               value="{{ $size['height']  }}"
                               step="0.1"
                               placeholder="{{ __('artwork.size.height') }} *">
                        <input class="px-3 py-1 rounded-full focus:outline-none focus:ring-0 max-w-[80px] placeholder:text-xs
                    placeholder:text-gray-600 text-sm" name="depth[{{ $i }}]" type="number" min="0" max="10000"
                               value="{{ $size['depth'] }}"
                               step="0.1"
                               placeholder="{{ __('artwork.size.depth') }}">
                    </div>
                    </fieldset>
              @endforeach
            @endif
        </div>
        <div class="col-span-12 w-full">
            <x-shared.form.filepicker :elementData="$formData['images']"/>
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select-colors :elementData="$formData['color']" />
        </div>
        <div class="col-span-12 w-full">
            <x-shared.form.textarea :elementData="$formData['description']" />
        </div>

    </div>

    <input class="rounded-full cursor-pointer py-4 px-10 text-white text-bold transition text-center
      bg-gradient-to-r from-primaryColor to-orange-400 w-full text-wrap" type="submit" name="go_sort" value="{{ __('artwork.actions.save_and_go_sort') }}" />
    <div class="mt-6"></div>
    <x-shared.form.helper.final-action content="{{ __('artwork.actions.perform_deletion') }}"
                                       deleteText="{{ __('core.delete_creativity') }}"
                                       saveText="{{ __('core.actions.save') }}"
    />
</form>
