<div class="form-element py-1.5" data-form-type='textarea'>
    <div class="relative z-0" data-area="form-element-wrapper">
        @error($name)
            <div class="form-element-errors">
                <span class="text-xs text-invalid-value">* {{ $message }}</span>
            </div>
        @enderror
        <textarea
            {{ $attributes->class([
                "
                    block py-3.75 px-6 w-full text-xs text-black
                    $bgColor border-0 appearance-none dark:text-white
                    dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0
                    peer rounded-3xl height-full resize-none
                    placeholder:text-xs placeholder:text-gray-600
                ",
                $invalidInputColorBg => $errors->has($name),
                ])
            }}
            id="input-{{ $name }}"
            name = "{{ $name }}"
            rows ="{{ $rows }}"
            placeholder="{{ $placeholder }}"
        >
        {{ $value }}
        </textarea>
    </div>
</div>
