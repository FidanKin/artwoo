<div class="user-info flex flex-row gap-x-4 items-center justify-between {{$reversedirection}}">
    <div class="icon w-[41px] h-[41px] rounded-full border-2 border-[#EF9308] overflow-hidden">
        <a href="/author/{{ $id }}">
            <img src="{{ $icon }}" />
        </a>
    </div>
    <div class="flex flex-col">
        <a href="/author/{{ $id }}">
            <span class="{{ $textStyles }} font-bold leading-none hover:text-primaryColor">{{ $text }}</span>
        </a>
        @if ($moreinfo === true)
            <div class="text-xsm">
                <span class="font-medium">{{ $artworktype }}</span>
                @if (!empty($age))
                    <span> {{ $age }}</span>
                @endif
            </div>
        @endif
    </div>

    @if(!empty($socials))
        <div class="flex gap-x-2 inline max-w-2">
        @foreach($socials as $text => $link)
            <x-shared.core.social-link :$link :$text />
        @endforeach
        </div>
    @endif
</div>
