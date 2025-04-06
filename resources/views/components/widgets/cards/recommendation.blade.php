<div class="{{ $indentStyles }} flex flex-row bg-white rounded-card
    justify-between" data-content="recommendation-card">
    <div class="space-x-5 flex flex-row items-center">
        @if($image)
            <div class="img">
                <x-shared.lib.artworkImage pathToImage="images/cosmo.jpg" imageType="small" />
            </div>
        @endif

        <div class="text text-xs text-sm-gray max-w-[504px]">
            <p>
                В год 150-летия Сергея Рахманинова знаменитая опера не менее известного
                композитора звучит с открытой сцены памятника архитектуры федерального значения
            </p>
            <span class="font-bold">
            01.06.2023 / 22:00
        </span>
        </div>
    </div>

    <div class="space-x-5 flex flex-row mr-5 items-center">
        <div class="author">
            <x-entity.user.lib.userInfo login="fidandev" icon="images/examples/my.jpg"
                                        artworktype="Дизайнер" age="26" size="xs" />
        </div>

        @if($availability)
            <div class=" availability">
                <x-shared.lib.base-icon iconurl="icons/block-content.svg" />
            </div>
        @endif
    </div>
</div>
