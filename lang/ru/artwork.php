<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Artwork Language Lines
    |--------------------------------------------------------------------------
    |
    | Language string for Artwork component
    |
    |
    |
    */

    'empty' => 'Работы отсутствуют :(',

    'artwork_category' => 'Категория',
    'artwork_name' => 'Название',
    'artwork_topic' => 'Тема',
    'product_price' => 'Стоимость',
    'choose_images' => 'Выберите изображения (до :max)',
    'topics_name' => 'Темы',
    'commerce' => 'Тип коммерческой работы',
    'description' => 'Описание',
    'sort_desc' => 'Расположените изображения в нужном для вас порядке, перетаскивая их. Первое в списке изображение также будет 
        использовано как превью.',
    'sort_title' => 'Сортировка изображений',
    'color_choose' => 'Основной цвет',
    'has_components' => 'Работа состоит из нескольких частей',
    'component_quantity' => 'Количество составных частей',
    'from' => 'от',
    'to' => 'до',

    // главные категории
    'types' => [
        'picture' => 'Картина',
        'handmade' => 'Хендмейд',
        'sculpture' => 'Скульптура',
    ],

    // основные темы работ для выбора
    'topics' => [
        'abstraction' => 'Абстракция',
        'animals' => 'Животные',
        'architecture' => 'Архитектура',
        'plants' => 'Цветы и растения', // цветы и растения
        'nature' => 'Природа',
        'erotica' => 'Эротика',
        'people' => 'Люди',
        'love' => 'Любовь',
        'technologies' => 'Технологии',
        'other' => 'Другое',
        'space' => 'Космос',
    ],

    // sizes
    'size' => [
        'width' => 'ширина',
        'height' => 'высота',
        'depth' => 'глубина',
    ],

    'colors' => [
        'orange' => 'Оранжевый',
        'red' => 'Красный',
        'green' => 'Зеленый',
        'blue' => 'Синий',
        'yellow' => 'Желтый',
        'brown' => 'Коричневый',
        'purple' => 'Фиолетовый',
        'gray' => 'Серый',
        'pink' => 'Розовый',
        'none' => 'Не задан',
        'black_white' => 'Черный \ белый'
    ],

    'artwork_size' => 'Размер: ',

    'actions' => [
        'perform_deletion' => 'Вы действительно хотите удалить авторскую работу?',
        'create' => 'Разместить работу',
        'save_and_go_sort' => 'Сохранить и задать порядок отображения изображений'
    ],

    'errors' => [
        'delete' => 'Не удалось выполнить удаление, попробуйте позже или сообщите администратору'
    ],

    'filter' => [
        'by_price_title' => 'По стоимости работы',
        'price_from' => 'Цена от',
        'price_to' => 'Цена до',
        'price_no' => 'Без указания стоимости',
        'all' => 'Все работы',
        'in_stock' => 'В наличии',
        'by_color_title' => 'По цвету работы',
        'by_size' => 'По размеру работы',
        'width_from' => 'Минимальная ширина',
        'width_to' => 'Максимальная ширина',
        'height_from' => 'Минимальная высота',
        'height_to' => 'Максимальная высота',
        'depth_from' => 'Минимальная глубина',
        'depth_to' => 'Максимальная глубина',
        'by_component_quantity' => 'Количество составных частей'

    ],

    'navigation' => [
        'artwork' => 'Работа: :name',
        'edit' => 'Редактирование работы',
        'edit_sort' => 'Сортировка изображений'
    ],

    'messages' => [
        'sorting_success_saved' => 'Сортировка сохранена',
        'sorting_not_saved' => 'Не удалось сохранить сортировку'
    ]
];
