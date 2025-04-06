<div class="form-element py-1.5" data-form-type='text'>
    <div class="relative z-0" data-area="form-element-wrapper">
        <input type="text"
            {{ $attributes->class([
                "
                    block py-3.75 px-6 w-full text-xs text-black appearance-none dark:text-white focus:outline-none
                    focus:ring-0 peer rounded-full
                ",
                $invalidInputColorBg => $errors->has($name),
                'text-black' => $errors->has($name),
                "$bgColor border-0" => empty($state),
                'bg-transparent border-black border-solid border' => !empty($state)
                ])
            }}
            id="input-{{ $name }}"
            name = "{{ $name }}"
            value = "{{ !empty($value) ? $value : old($name) }}"
            {{ $state }}
        />
        <label for="input-{{ $name }}"
            {{ $attributes->class([
                '
                    absolute text-xs text-gray-600
                    duration-300 transform top-3.75 left-6 -z-10 origin-[0]
                    peer-focus:left-6 peer-focus:rounded-full peer-focus:dark:text-blue-500
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                    peer-focus:scale-75 peer-focus:-translate-y-4 z-50 form-control-label
                ',
                $invalidInputColorText => $errors->has($name)
            ]) }}
            >
            @error($name) {{ $message }} @else {{ $placeholder }} @enderror
        </label>
    </div>
</div>
