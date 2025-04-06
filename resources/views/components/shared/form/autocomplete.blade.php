<div class="form-element py-1.5" data-form-type='autocomplete'>
    <div class="relative z-0" data-area="form-element-wrapper">
        <input type="text"
            {{ $attributes->class([
                "
                    autocomplete block !py-3 !px-6 w-full text-xs text-black
                    $bgColor border-none appearance-none focus:outline-none
                    rounded-full placeholder:text-black
                ",
                $invalidInputColorBg => $errors->has($name),
                'text-white' => $errors->has($name)
                ])
            }}
            id="input-{{ $name }}"
            name = "{{ $name }}"
            value = "{{ $value }}"
            placeholder="{{ $placeholder }}"
            data-whitelist="{{ $defaultTags }}"
        />
    </div>
</div>
