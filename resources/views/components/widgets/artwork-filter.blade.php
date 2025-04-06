@props([
            'grid_df' => 'col-span-4',
            'accesstype' => [
                '1' => 'Полный',
                '2' => 'По ссылке',
                '3' => 'Только авторизованным'
            ],
            'type' => [
                '0' => 'Фотография',
                '1' => 'Картина',
                '2' => 'Скульптура'
            ],
            'likes' => [
               10 => 10,
               100 => 100,
               1000 => 1000
            ],
            'countries' => [
                'ru' => 'Россия',
                'kz' => 'Казахстан',
                'au' => 'Австралия'

            ],
            'years' => [
                2000, 2001, 2002, 2003, 2004, 2005
            ],
            'commerce' => [
                0 => 'Некоммерческая',
                1 => 'Коммерческая'
            ]

])

<!-- У нас 12 колонок -->
<form id="{{ $formid }}" method="POST" >
    <div id="edit-content" class="grid grid-cols-12 auto-rows-auto gap-3 mb-9">
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options="$type"
                name='artwork_type'
                placeholder="Тип работы"
            />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options="$type"
                name='type'
                placeholder="Тип работы"
            />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options="$likes"
                name='likes_count'
                placeholder="Количество лайков"
            />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options="$years"
                name='created_at'
                placeholder="Дата создания"
            />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='name' placeholder="Стоимость" />
        </div>
        <div class="col-span-2">
            <x-shared.form.textInput name='size_width' placeholder="Размер: по длине" />
        </div>
        <div class="col-span-2">
            <x-shared.form.textInput name='size_height' placeholder="Размер: по высоте" />
        </div>
    </div>
    <x-shared.form.helper.filter-action />
</form>
