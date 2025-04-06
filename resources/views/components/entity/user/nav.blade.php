<div class="artwork-links space-x-10.5">
    @foreach($links as $key => $text)
        <a
            @class([
                "text-h4 inline",
                'text-primaryColor underline' => $activeLink === $key,
                'text-black no-underline' => $activeLink !== $key
            ])
            href="/{{ $key }}"
        >
            {{ $text }}
        </a>
    @endforeach
</div>
