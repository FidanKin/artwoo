@if($isButton)
    <div class="mx-1 max-md:w-full">
@endif
    <a href="{{ $url }}"
        {{
            $attributes->class([
                "$styleClasses text-center",
                'w-full inline-block ease-linear duration-100' => $isButton,
                'no-underline' => !$underline,
                'underline' => $underline,
                'rounded-full' => $isButton
            ])
        }}
        target="_self"
    >
    {!! $text !!}
</a>
@if($isButton)
</div>
@endif
