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
    <div id="edit-content" class="grid grid-cols-12 auto-rows-auto gap-3 {{ $indentStyles }}">
        <div class="{{ $grid_df }}">
            <x-shared.form.textInput name='name' placeholder="Заголовок" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.autocomplete name='tags' placeholder="Тэги" />
        </div>
        <div class="col-span-12 row-start-2 w-full">
            <x-shared.form.filepicker name='ifile'/>
        </div>
        <div class="{{ $grid_df }} row-span-3">
            <x-shared.form.textarea name='short' placeholder="Краткое описание" />
        </div>
        <div class="{{ $grid_df }} row-span-3">
            <x-shared.form.textarea name='content' placeholder="Содержимое" />
        </div>
        <div class="{{ $grid_df }}">
            <x-shared.form.select
                :options=$accesstype
                name='access_type'
                placeholder="Доступность" />
        </div>
    </div>
    <x-shared.form.helper.finalAction deleteText='Удалить запись' />
</form>
