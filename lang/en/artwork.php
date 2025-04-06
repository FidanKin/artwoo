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

    'empty' => 'No artworks :(',

    'artwork_category' => 'Type of publication',
    'artwork_name' => 'The name',
    'product_price' => 'Price',
    'choose_images' => 'Choose images (max - :max)',
    'topics_name' => 'Topics',
    'commerce' => 'Type of commercial artwork',
    'description' => 'Description',
    'sort_desc' => 'Arrange the images in the order you need by dragging them. The first image in the list will also be 
        used as a preview.',
    'sort_title' => 'Sort images',
    'color_choose' => 'Main color',
    'has_components' => 'Multi-part work',
    'component_quantity' => 'Number of components',
    'from' => 'from',
    'to' => 'to',

    // main categories
    'types' => [
        'picture' => 'Picture',
        'handmade' => 'Handmade',
        'sculpture' => 'Sculpture',
    ],

    // основные темы работ для выбора
    'topics' => [
        'abstraction' => 'Abstraction',
        'animals' => 'Animals',
        'architecture' => 'Architecture',
        'plants' => 'Flowers and plants', // цветы и растения
        'nature' => 'Nature',
        'erotica' => 'Erotica',
        'people' => 'People',
        'love' => 'Love',
        'technologies' => 'Technologies',
        'other' => 'Other',
        'space' => 'Space',
    ],

    // sizes
    'size' => [
        'width' => 'width',
        'height' => 'height',
        'depth' => 'depth'
    ],

    'colors' => [
        'orange' => 'Orange',
        'red' => 'Red',
        'green' => 'Green',
        'blue' => 'Blue',
        'yellow' => 'Yellow',
        'brown' => 'Brown',
        'purple' => 'Purple',
        'gray' => 'Gray',
        'pink' => 'Pink',
        'none' => 'None',
        'black_white' => 'Black \ white'
    ],

    'artwork_size' => 'Size: ',

    'actions' => [
        'perform_deletion' => 'Do you really want to delete the author\'s work?',
        'create' => 'Post artwork',
        'save_and_go_sort' => 'Save and set the image display order'
    ],

    'errors' => [
        'delete' => 'The deletion failed, try again later or notify the administrator'
    ],

    'filter' => [
        'by_price_title' => 'By artwork price',
        'price_from' => 'Price from',
        'price_to' => 'Price to',
        'price_no' => 'No Price',
        'all' => 'All artworks',
        'in_stock' => 'In stocks',
        'by_size' => 'By artwork size',
        'width_from' => 'Minimum width',
        'width_to' => 'Maximum width',
        'height_from' => 'Minimum height',
        'height_to' => 'Maximum height',
        'depth_from' => 'Minimum depth',
        'depth_to' => 'Maximum depth',
        'by_component_quantity' => 'Number of components'
    ],

    'navigation' => [
        'artwork' => 'Artwork: :name',
        'edit' => 'Edit artwork',
        'edit_sort' => 'Sorting images'
    ],

    'messages' => [
        'sorting_success_saved' => 'The sorting is saved',
        'sorting_not_saved' => 'Couldn\'t save the sorting'
    ]

];
