<div
    {{
        $attributes->class([
            'form-element py-1.5',
            'w-full' => $fullWidth
        ])
    }}
    data-form-type='search'
>
    <div class="relative z-0" data-area="form-element-wrapper">
        <div
            @class([
                "search-container $inputSizeStyles pl-[23px] pr-2 rounded-full flex flex-row items-center",
                'bg-base-gray' => $searchInputColor === 'gray',
                'bg-white' => $searchInputColor === 'white'
            ])
        >
            <form id="search-filter" method="GET"></form>
            <x-shared.core.icon additionalStyles='mr-3' path='icons/search.svg' />
            <input type="text"
                {{ $attributes->class([
                    "
                        block w-full text-sm text-black h-10
                        border-0 bg-transparent appearance-none dark:text-white
                        dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0
                        peer
                    ",
                    ])
                }}
                id="input-search"
                name = "search"
                placeholder="{{ __('core.query_search') }}"
                value = "{{ $searches['search'] ?? '' }}"
                form="search-filter"
            />
            @if($enablefilter)
                <x-shared.form.helper.filter :size="$filterSize" />
                <x-widgets.lib.modal-custom id="global-filter" title="{{ __('core.search.main_filter_title') }}" actionUrl="" actionLabel="" closeText="" method="">
                    <form action="{{ request()->path() }}" method="GET">
                        <fieldset class="border px-3 mb-4 border-primaryColor rounded">
                            <legend class="ml-4 px-1 font-bold mb-2">{{ __('artwork.filter.by_price_title') }}</legend>
                            <input type="int"
                                   name="price_from"
                                   class="border rounded px-2 py-1 mb-2 w-full appearance-none focus:outline-none focus:border-primaryColor text-black"
                                   placeholder="{{ __('artwork.filter.price_from') }}"
                                   value="{{ $searches['price_from'] ?? '' }}"
                            />
                            <input type="int"
                                   name="price_to"
                                   class="border rounded px-2 py-1 mb-2 w-full appearance-none focus:outline-none focus:border-primaryColor text-black"
                                   placeholder="{{ __('artwork.filter.price_to') }}"
                                   value="{{ $searches['price_to'] ?? '' }}"
                            />
                            <input id="no-price-filter" type="checkbox" name="price_no" @checked(isset($searches['price_no'])) />
                            <label for="no-price-filter" class="text-sm">{{ __('artwork.filter.price_no') }}</label>
                        </fieldset>
                        <fieldset class="border px-3 mb-4 border-primaryColor rounded">
                            <legend class="ml-4 px-1 font-bold mb-2">{{ __('artwork.filter.by_color_title') }}</legend>
                            @foreach($artworkColors as $key => $string)
                                <label>
                                    <div class="flex flex-row pb-2">
                                        <span class="custom-select-color {{ $key }}"></span>
                                        <input type="checkbox" name="color[{{ $key }}]" class="ml-3.5" @checked(isset($searches['color'][$key])) />
                                    </div>
                                </label>
                            @endforeach
                        </fieldset>
                        <fieldset class="border px-3 mb-4 border-primaryColor rounded">
                            <legend class="ml-4 px-1 font-bold mb-2">{{ __('artwork.filter.by_size') }}</legend>

                            @foreach(['width', 'height', 'depth'] as $sizeName)
                                <span class="text-center">{{ mb_ucfirst(__("artwork.size.{$sizeName}")) }}</span>
                                <div class="flex flex-row mb-3 gap-x-8">
                                    <div class="flex flex-row gap-x-1 items-center">
                                        <span class="text-sm">{{ __('artwork.from') }}</span>
                                        <input type="int"
                                               min="0"
                                               step="0.1"
                                               name="{{ $sizeName }}_from"
                                               class="border rounded px-2 mb-2 w-full appearance-none focus:outline-none focus:border-primaryColor text-black"
                                               value="{{ $searches["{$sizeName}_from"] ?? '' }}"
                                        />
                                    </div>
                                    <div class="flex flex-row gap-x-1 items-center">
                                        <span class="text-sm">{{ __('artwork.to') }}</span>
                                        <input type="int"
                                               min="0"
                                               step="0.1"
                                               name="{{ $sizeName }}_to"
                                               class="border rounded px-2 mb-2 w-full appearance-none focus:outline-none focus:border-primaryColor text-black"
                                               value="{{ $searches["{$sizeName}_to"] ?? '' }}"
                                        />
                                    </div>
                                </div>
                            @endforeach

                        </fieldset>

                        <fieldset class="border px-3 mb-4 border-primaryColor rounded">
                            <legend class="ml-4 px-1 font-bold mb-2">{{ __('artwork.filter.by_component_quantity') }}</legend>
                            <input type="number" name="component_number" min="0" max="5" placeholder="{{ __('core.quantity') }}"
                                class="border appearance-auto default_appearance rounded px-2 mb-2 w-full text-black"
                                value="{{ $searches['component_number'] ?? 0 }}"
                            />
                        </fieldset>

                        <x-shared.form.submit-input name='submit-filters' text='Найти' isDark="{{ false }}" size="sm" />
                    </form>
                </x-widgets.lib.modal-custom>
            @endif
            <div class="w-2.5"></div>
            <x-shared.form.submit-input form="search-filter" name='submit-search' text='Поиск' isDark="{{ true }}" :size="$submitsize" />
        </div>

        {{--  Очистка всех фильтров - очищаем все параметры запроса, оставляем только путь --}}
        @if(!empty(request()->query()))
            <span class="mt-1 block">
                <a href="{{ url(request()->path()) }}" class="text-primaryColor hover:text-dark-blue">{{ __('core.search.reset_filters') }}</a>
        </span>
        @endif
    </div>
</div>
