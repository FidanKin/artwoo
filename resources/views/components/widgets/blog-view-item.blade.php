@php
    $item = [
        [
            'value' => 'Финальный приз: Профильные курсы на 60 дней',
            'isbold' => true
        ]
    ];
    $rightitem = [
        [
            'type' => 'text',
            'value' => 'г. Москва, ул. Победа 68 <img class="inline-block" src="http://127.0.0.1:8000/icons/location.svg" />',
            'color' => 'gray'
        ],
        [
            'type' => 'icon',
            'value' => 'icons/artwork/price.svg',
        ],
        [
            'type' => 'text',
            'value' => '1 600$'
        ],
    ];

    $txts = [
      'Полное наименование компании: ФГБУ Национальный парк Ладожские шхеры,
      Основные функции нацпарка: сохранение природных ландшафтов, рекреация (отдых),
       просветительская работа. Подробнее о нас можно почитать на нашем сайте...',
       'Пожелания к логотипу:
        Логотип должен иметь узнаваемый графический символ. Необходимо иметь 2 варианта использования:
        графический символ отдельно и графический символ с текстом Национальный парк «Ладожские шхеры».
        Например как логотип Пепси – красно-сине-белый кружок и тот же кружок кружок с надписью Pepsi под
        ним. Логотип должен иметь монохромную версию или качественно выглядеть при монохромном отображении.
        Желательный ассоциативный ряд к логотипу: экологичность, природа, добро, гостеприимство, Карелия-
        Маскот: Ладожская нерпа. Итоговый результат должен быть представлен в векторе. Использоваться будет в
        веб-дизайне, полиграфии и медиа.'
    ];
@endphp
<x-entity.user.intro backgroundColor="white" >
    <x-shared.lib.baseIcon
        iconurl='icons/socials/telegram.svg'
        darkBg="{{ true }}"
        width='w-9'
        height='h-9'
    />
</x-entity.user.intro>
<x-widgets.lib.contentMetaInfo tagurl='tag?name=fidan&area=l' tagtext='Блог'
                               :maininfo="$item" :secondaryinfo="$rightitem" >
</x-widgets.lib.contentMetaInfo>

<div id="blog-item-view" class="pt-px mb-16">
        <x-entity.lib.description-base :paragraphs="$txts" />
        <x-shared.lib.collections.tags bgcolor='gray' />
</div>
<div class="space-y-4.5">
    <x-widgets.cards.recommendation />
    <x-widgets.cards.recommendation image="{{ false }}" availability="{{ false }}" />
</div>
