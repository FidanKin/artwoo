<div class="artwork-collection {{ $classes }}">
    <div class="flex flex-row justify-center gap-x-5 flex-wrap max-mm:flex-col max-mm:items-center">
        @if(!empty($items))
            @foreach ($items as $artwork)
                <x-widgets.cards.artworkItem :$artwork />
            @endforeach
        @else
            <p>{{ __('artwork.empty') }}</p>
        @endif
    </div>
</div>
