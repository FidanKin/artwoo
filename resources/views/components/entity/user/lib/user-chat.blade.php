<div class="user-info flex flex-row gap-x-4 items-center justify-between {{$reversedirection}}">
    <div class="icon {{ $getIconSize() }} rounded-full border-2 border-[#EF9308] overflow-hidden shrink-0">
        <img src="{{ url($icon) }}" />
    </div>
    <div class="flex flex-col">
        @if($enablelogin)
            <div class="user-login flex flex-row gap-x-1.5">
                <span class="{{ $textStyles }} font-bold leading-none">{{ $text }}</span>
                @if($messagecount)
                    <div class="message-counter min-w-[25px] h-[25px] bg-primaryColor
                rounded-full text-white relative">
                    <span class="text-base font-bold absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        {{ $messagecount }}
                    </span>
                    </div>
                @endif
            </div>
        @endif
        <div class="{{ $getStatusSize() }}">
            <span class="text-sm-gray font-medium">{{ $status }}</span>
        </div>
    </div>
</div>
