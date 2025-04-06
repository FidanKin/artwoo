<div id="submit-button"
    {{ $attributes->class([
        'mt-12' => $includeMt
        ])
    }}
>
    <input
     name ="{{ $name }}"
     {{ $attributes->class([
        "rounded-full cursor-pointer $elSize text-white text-bold transition text-center",
        'bg-primaryColor hover:bg-black' => !$isDark,
        'w-full' => $isFullWidth,
        'bg-black' => $isDark
        ]) }}
     type="submit" value="{{ $text }}"
     @if($form)
         form="{{ $form }}"
     @endif
    />
    <div class="hidden bg-primaryColor py-6 text-white text-bold px-40 hover:bg-black"></div>
</div>
