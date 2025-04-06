<?php

namespace App\View\Core\Interfaces;

/**
 * Интерфейс для работы с фоном
 */
interface BackgroundInterface {

    /**
     * Ключ, который будет использоваться для классов фона в шаблоне blade
     */
    const DEFAULT_BACKGROUND_STYLES_KEY = 'backgroundStyles';

    /**
     * Получение класса (tailwind) цвета фона
     */
    public function getBackgroundColor();
}
