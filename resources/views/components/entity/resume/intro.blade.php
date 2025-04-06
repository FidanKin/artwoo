{{-- Для проверки отображения навыкок --}}
@php
    $skills[] = 'API';
    $skills[] = 'Yt';
    $skills[] = 'FFF';
@endphp


{{-- Информация в "шапке" резюме --}}
<div id="resume-intro" class="flex flex-col gap-y-6">
    <div id="resume-intro-main" class="flex flex-row gap-x-3.5">
        {{-- Предпочитаемая сфера работы (кнопка - ссылка на все такие ) --}}
        <x-shared.lib.buttonLink url='/tags/photo' backgroundColor="primary" text='Фотография'
            padding="btn-sm-high"/>
        <div class="bg-white rounded-full py-1 px-7 w-full flex flex-row min-h-[44px] items-center justify-between">
            <div class="exp text-xs">
                <span class="font-bold">Опыт работы 9 лет</span>
                /
                <span>Художественное образование</span>
                /
                <span class="font-bold">90 000 руб</span>
            </div>
            <div id="resume-social" class="tags flex flex-row gap-x-1.5">
                <x-shared.lib.baseIcon iconurl='icons/socials/telegram.svg' darkBg="{{ true }}" />
            </div>
        </div>
    </div>
    <x-shared.lib.divider />
</div>
