<div class="form-element password py-1.5" data-form-type='password'>
    <div class="relative z-0" data-area="form-element-wrapper">
        <input
            name = "{{ $name }}"
            type="password"
            id="input-{{ $name }}"
            {{  $attributes->class([
                'block py-3.75 px-6 w-full text-xs text-black
                    bg-[#F2F5F6] border-0 appearance-none dark:text-white
                    dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0
                    peer rounded-full',
                    $invalidInputColorBg => $errors->has($name),
                ])
            }}
            value = "{{ old($name) }}"
        />
        <label for="input-{{ $name }}"
            {{  $attributes->class([
                'absolute text-xs text-gray-600
                duration-300 transform top-3.75 left-6 -z-10 origin-[0]
                peer-focus:left-6 peer-focus:rounded-full peer-focus:dark:text-blue-500
                peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-4 z-50 form-control-label',
                $invalidInputColorText => $errors->has($name)
                ])
            }}
        >
            @error($name) {{ $message }} @else {{ $placeholder }} @enderror
        </label>
        <div class="absolute z-100 inset-y-0 right-0 flex items-center pr-3">
            <img id="password-icon" class="scale-75 z-100 password-icon" src="/icons/password.svg">
         </div>
    </div>
</div>
