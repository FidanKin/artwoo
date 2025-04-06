{{-- Шаблон тега --}}
<div data-content-type="tag">
    @if($tag->isActive)
        <a href="{{ url("/{$tag->query}={$tag->slag}&clean_tag=1") }}">
    @else
        <a href="{{ url("/{$tag->query}={$tag->slag}") }}">
    @endif

            <span @class([
                    "$bgcolorclass block rounded-full py-2.5 px-3.5 text-strong-gray text-xsm font-medium",
                    'bg-black text-white' => $tag->isActive
                ])
            >
                {{ $tag->text }}
            </span>
        </a>
</div>
