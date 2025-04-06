<?php

namespace Source\Helper;

/**
 * Класс для работы с формами и преобразования значений с форм
 * Реализует статические методы
 */
class FormHelper
{
    /**
     * Метод для конвертации значения чекбокса из формы в bool (1 0)
     *
     * @param string $value - значение чекбокса
     * @return int
     */
    public static function checkboxToBool(string $value) {
        return $value === 'on' ? 1 : 0;
    }
}
