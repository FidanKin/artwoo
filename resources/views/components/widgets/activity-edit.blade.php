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
            ]

        ])

<!-- У нас 12 колонок -->
<form id="{{ $formId }}" method="POST" >
    <div id="edit-content" class="grid grid-cols-12 grid-rows-6 gap-3 {{ $indentStyles  }}">
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='name' placeholder="Название мероприятия" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='place' placeholder="Место проведения" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$type
                name='artwork_type'
                placeholder="Тип работы" />
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
            <x-shared.form.textInput name='cost' placeholder="Стоимость" />
        </div>
        <div class="{{ $grid_df }} row-span-3">
            <x-shared.form.textarea name='requirements' placeholder="Требования для участников" />
        </div>
        <div class="{{ $grid_df }} row-span-3">
            <x-shared.form.textarea name='contacts' placeholder="Контакты для связи" />
        </div>
        <div class="{{ $grid_df }} row-span-3">
            <x-shared.form.textarea name='description' placeholder="Описание мероприятия" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$accesstype
                name='access_type'
                placeholder="Доступность" />
        </div>
    </div>
    <x-shared.form.helper.finalAction deleteText='Удалить мероприятие' />
</form>
