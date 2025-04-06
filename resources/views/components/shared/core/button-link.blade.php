<div class="mx-1">
    <a href="{{ $url }}"
        {{
            $attributes->class([
                "w-full text-white no-underline text-xs py-3 px-6
                block text-center rounded-full $fontweight",
                'bg-black' => $darkBg,
                'bg-primaryColor' => !$darkBg
            ])
        }}
    >
        {{ $text }}
    </a>
</div>