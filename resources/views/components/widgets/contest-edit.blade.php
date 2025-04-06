@props([
            'grid_df' => 'col-span-4',
            'max_artworks' => [
                '1' => 1,
                '2' => 2,
                '3' => 3
            ],
            'type' => [
                '0' => 'Фотография',
                '1' => 'Картина',
                '2' => 'Скульптура'
            ]

        ])
<!-- У нас 12 колонок -->
<form id="{{ $formId }}" method="POST" >
    <div id="edit-content" class="grid grid-cols-12 auto-rows-auto gap-3 {{ $indentStyles }}">
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='name' placeholder="Название конкурса" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$max_artworks
                name='max_artworks'
                placeholder="Максимальное количество работ" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='prize' placeholder="Приз за участие" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.datepicker name='date_start'
                placeholder="Дата начала" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.datepicker name='date_end'
                placeholder="Дата окончания" />
        </div>
        <div class="{{ $grid_df }}">

        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$timeSlices
                name='time_start'
                placeholder="Время начала" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$timeSlices
                name='time_end'
                placeholder="Время окончания" />
        </div>
        <div class="{{ $grid_df }}">

        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.datepicker name='date_publish'
                placeholder="Дата публикации результатов" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$timeSlices
                name='time_end'
                placeholder="Время публикации результатов" />
        </div>
        <div class="{{ $grid_df }}">

        </div>
        <div class="col-span-12 row-span-3">
            <x-shared.form.textarea name='description' placeholder="Описание конкурса" />
        </div>
        <div class="col-span-12 row-span-1">
            <x-shared.form.textarea rows=1 name='conditions' placeholder="Условия проведения" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='result_publish' placeholder="Где узнать о результатах" />
        </div>
    </div>
    <x-shared.form.helper.finalAction deleteText='Удалить конкурс' />
</form>
