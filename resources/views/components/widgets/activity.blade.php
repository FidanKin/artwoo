@props([
            'content' => 'В год 150-летия Сергея Рахманинова знаменитая опера не менее известного
                композитора звучит с открытой сцены памятника архитектуры федерального значения'
])
    <div class="activities-container {{ $indentStyles  }}">
        <div class="activities-list flex flex-row gap-5 flex-wrap">
            @for($i=0; $i < 20; $i++)
                @if($i % 2 === 0)
                    <x-widgets.cards.activityItem title="Опера «Алеко»" subtitle='г. Москва, ул. Победа 68'
                        :content="$content" buttontext='Ознакомиться' details='01.06.2022' status='Идет' />
                @else
                    <x-widgets.cards.activityItem title="Художественная ярмарка 'Радость'" subtitle='г. Москва, ул. Победа 68'
                        :content="$content" buttontext='Ознакомиться' details='01.06.2022' status='Прошел' />
                @endif
            @endfor
        </div>
    </div>
