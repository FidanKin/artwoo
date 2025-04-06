<?php

namespace App\View\Core\Interfaces;

/**
 * Интерфейс для работы с текстом
 */
interface TextInterface {
    const DEFAULT_TEXT_STYLES_KEY = 'textStyles';
    /**
     * Получение цвета текста
     */
    public function getTextColor() : string;

    /**
     * получение веса текста
     */
    public function getTextWeight() : string;

    /**
     * Получение размера текста
     */
    public function getTextSize() : string;
}
