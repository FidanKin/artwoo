<section data-content="notification" class="py-4.5 px-6.5 bg-white flex flex-row rounded-imageSm justify-between" >
    <div class="content basis-7/12">
        <x-shared.core.title :text="$title" size="h4" weight="bold"
                             color="primary"/>
        <p class="text-xs text-sm-gray">
            {{ $description }}
        </p>
    </div>
    <div class="actions flex flex-row items-center gap-x-7">
                <span class="font-medium text-black text-xsm">
                    {{ $datetext }}
                </span>
        <x-shared.core.close-button />
    </div>
</section>
