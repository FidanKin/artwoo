<div class="artwork-item max-w-card mb-9 w-[225px]">
    <div class="w-fit">
        <a href="{{ url('/artwork/' . $artwork['id']) }}">
            <x-shared.lib.artwork-image :pathToImage="$artwork['image']" imageType="preview" />
        </a>
        <div class="artwork-item__description mt-3 leading-none flex flex-row">
            @if($artwork['price'] > 0)
                <div class="mr-[9px] artwork_item__cost" data-cost="{{ $artwork['price'] }}">
                    <div class="w-[33px] h-[33px] bg-primaryColor rounded-full">
                        <img class="mx-auto pt-2" src="{{ url("/icons/cost.svg") }}" />
                    </div>
                </div>
            @endif
            <div class="info flex flex-row justify-between items-center w-full">
                <div class="description">
                    <div class="title">
                        <x-shared.core.title size='h4' weight="medium" :text="$artwork['name']" />
                    </div>
                    <span class="font-roboto text-xsm text-sm-gray ">{{ $artwork['category'] }}</span>
                </div>
{{--                типо менюшки для редактирования --}}
{{--                    <div class="flex flex-row gap-x-0.5 p-0.5 cursor-pointer">--}}
{{--                        <span class="w-1.5 h-1.5 bg-high-gray block rounded-full"></span>--}}
{{--                        <span class="w-1.5 h-1.5 bg-high-gray block rounded-full"></span>--}}
{{--                        <span class="w-1.5 h-1.5 bg-high-gray block rounded-full"></span>--}}
{{--                    </div>--}}
            </div>
        </div>
    </div>
</div>
