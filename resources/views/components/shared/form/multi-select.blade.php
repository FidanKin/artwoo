<div class="py-1.5 mx-1 relative z-10">
    <div class="relative z-0 input-select" data-area="form-element-wrapper">
        <div id="ac1"
            {{  $attributes->class([
                "select-menu block pl-6 pr-3 w-full text-xs text-black min-w-[150px]
                border-0 appearance-none rounded-full flex justify-between",
                $invalidInputColorBg => $errors->has($name),
                'text-white' => $errors->has($name)
                ])
            }}
        >
        </div>

        @if(count($options['select']) > 1)
            <div class="select-1-data block relative z-50">
                <select name="field1" id="field1" class="text-xs" multiple multiselect-hide-x="false" placeholder="{{ $placeholder }}">
                    @foreach ($options['select'] as $key => $displayValue)
                        <option class="text-xs" value="{{ $key }}">{{ $displayValue }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
</div>
