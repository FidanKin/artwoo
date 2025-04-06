<?php

namespace App\View\Core\Interfaces;

interface InputInterface
{
    const INPUT_SIZE_CLASSES_KEY = 'inputSizeStyles';

    /**
     * Получение стилей для размера инпута
     *
     * @return string
     */
    public function getInputSize() : string;
}
