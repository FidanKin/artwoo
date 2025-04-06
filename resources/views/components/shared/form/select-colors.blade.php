<div class="form-element py-1.5 mx-1 relative" data-form-type='select'>
    <div class="relative z-10 input-select" data-area="form-element-wrapper">
        <div id="{{ $name }}"
                {{  $attributes->class([
                    "select-menu block pl-6 pr-3 w-full text-xs text-black min-w-[150px]
                    border-0 appearance-none rounded-full flex justify-between",
                    $convertSizeToCss($size),
                    $invalidInputColorBg => $errors->has($name),
                    'bg-primaryColor' => $isActive,
                    $bgColor => !$isActive
                    ])
                }}
        >
            <span id="select-color" class="form-control-label text-gray-600">
                @error($name) {{ $message }}
                @else <div class="flex flex-row justify-center content-center">
                        <span class="custom-select-color {{ $value }}"></span>
                        <span class="ml-1.5 leading-loose">{{ $placeholder }}</span>
                    </div>
                @enderror
            </span>
            <input @disabled(count($options['select']) < 1) name="{{ $name }}"
                   class="hidden" type="text"
                   value = "{{ empty(old($name)) ? $value : old($name) }}"
            />
            <!--<div class="absolute inset-y-0 right-0 top-6 pr-3 pointer-events-none select-icon"> -->
            <div class="inset-y-0 pointer-events-none select-icon">
                <img {{
                        $attributes->class([
                            'scale-75 inline',
                            'brightness-200' => $isActive
                        ])
                    }} src="/icons/drop-down-arrow.svg">
            </div>
        </div>

        @if(count($options['select']) > 1)
            <div class="{{ $name }} block hidden z-50 relative" data-select-target="{{ $name }}">
                <ul
                        {{
                            $attributes->class([
                                "select-1-data-list rounded-b-3xl absolute w-full z-50 border-x-slate-100 border border-t-transparent
                                 bg-white max-h-80 overflow-y-auto",
                                $bgColor => !$isActive
                            ])
                        }}>
                    @foreach ($options['select'] as $key => $langString)
                        <li class="py-4 px-6 hover:bg-primaryColor text-xs hover:text-white hover:last:rounded-b-3xl"
                            data-value="{{ $key }}" data-color="{{ $key }}"
                        >
                            <div class="flex flex-row justify-between">{{ $langString }}
                                <span class="custom-select-color {{ $key}}"></span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>