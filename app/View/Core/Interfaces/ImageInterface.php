<?php

namespace App\View\Core\Interfaces;

/**
 * Интерфейс для изображением
 */
interface ImageInterface {
    /**
     * Ключ по умолчанию, который можно использовать при
     *  передаче классов изображения в шаблон blade
     */
    const IMAGE_STYLES_KEY = 'imageStyles';
    /**
     * Типы изображений
     */
    const IMAGE_TYPES = [
        'full', 'preview', 'small', 'auth'
    ];
    /**
     * размер изображения при просмотре его в работах автора
     * (можно сказать, что полное изображение)
     */
    const FULL_IMAGE_SIZE_CLASSES = 'max-w-[375px] max-h-[445px] h-full w-full';
    /**
     * размер изображения при просмотре его в коллекции изображений
     * (превьюшки)
     */
    const PREVIEW_IMAGE_SIZE_CLASSES = 'w-[225px] h-[250px] object-cover';
    /**
     * Размер изобржения при просмотре списка авторов (ширина больше высоты)
     *  Используется, когда нам нужно в неком инлайн контейнере отобразить изображения
     */
    const SMALL_IMAGE_SIZE_CLASSES = 'w-[95px] h-[70px] object-cover';
    /**
     * Размер изображения, когда необходимо его отобразить на пол экрана
     *  обычно,это страница авторизации пользователя
     */
    const AUTH_PAGE_IMAGE_SIZE_CLASSES = 'max-w-[375px] max-h-[445px] h-full w-full';

    // 15 20 25
    const BORDER_RADIUSES = [
        'sm' => 'rounded-imageSm',
        'md' => 'rounded-imageMd',
        'big' => 'rounded-imageBig'
    ];



    /**
     * Получение класса (tailwind) внутреннего отступа
     */
    public function getImagePath();
}
