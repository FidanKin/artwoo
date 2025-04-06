<div class="form-element py-1.5" data-form-type='checkbox'>
    <div class="" data-area="form-element-wrapper">
        <label for="{{ $id }}"
               class="ml-1 text-xs text-black pt-0 flex flex-row items-center"
        >
            <div @class(["checkbox_container inline-block rounded-lg relative
                w-[25px] h-[25px] flex justify-center items-center shrink-0 mr-1",
                'bg-white' => $bgwhite,
                'bg-light-gray' => !$bgwhite
                ])
            >
                <input type="checkbox"
                       id="{{ $id }}"
                       name="{{ $name }}"
                       class="hidden peer"
                    @checked($value || old($name))
                />
                <span class="checkmark inline-block rotate-45 h-3 w-1.5 invisible
                    border-b-2 border-r-2 border-solid border-b-primaryColor border-r-primaryColor
                    rounded-[1px] peer-checked:visible"></span>
            </div>
            @if (isset($options['has_link']) && $options['has_link'])
                <span class="ml-3 text-sm text-sm-gray">{!!  $placeholder !!}</span>
            @else
                <span class="ml-3 text-sm text-sm-gray">{{ $placeholder }}</span>
            @endif

            @error($name)
                <span class="ml-6 text-inputInvalid block form-control-label">
                    * {{ $message }}
                </span>
            @enderror
        </label>
    </div>
</div>
