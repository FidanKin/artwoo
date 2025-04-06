<div class="activity-item max-w-card rounded-card bg-base-gray">
    <div class="container p-5">
        <div class="header">
            <div class="header-wrapper flex flex-row justify-between items-center">
                <x-shared.core.title :text="$title" size='h4' weight='medium'
                    containerClasses="leading-none"/>
                @if ($status)
                    <span class="p-1.5 bg-primaryColor text-white font-bold rounded text-[10px]">
                        {{ $status }}
                    </span>
                @endif
            </div>
            @if( $subtitle )
                <span class="text-sm-gray text-xsm font-semibold">{{ $subtitle }}</span>
            @endif
        </div>
        <!-- Описание -->
        <div class="activity-item__description my-2 leading-none">
            <div class="description my-6">
                <span class="text-sm-gray text-xs">{{ $content }}</span>
            </div>
            <x-shared.lib.buttonLink url="vk.com" :text=$buttontext borderColor="primary"
                borderRadius="full" color="primary" backgroundColor="none" weight="bold"        />
            </a>
        </div>

        <div class="details text-center">
            <span class="text-sm-gray text-xsm">{{  $details }}</span>
        </div>
    </div>
</div>
