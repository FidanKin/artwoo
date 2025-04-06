<?php

namespace App\View\Core\Abstract;

use App\View\Core\Interfaces\TextInterface;
use App\View\Core\Abstract\BaseAbstract;

/**
 * Интерфейс для работы с текстом
 */
abstract class TextAbstract extends BaseAbstract implements TextInterface  {
     public string $text;
     public string $color;
     public string $size;
     public string $weight;

    /**
     * Получение допустимых цветов для текста
     *
     * @return string[]
     */
    protected function allowedTextColors() {
        return [
            'white' => 'text-white',
            'black' => 'text-black',
            'primary' => 'text-primaryColor',
            'default' => 'text-white',
            'gray' => 'text-gray'
        ];
    }

    /**
     * Получение допустимых размеров для текста
     *
     * @return string[]
     */
    protected function allowedTextSizes() {
        return [
            'xxsm' => 'text-xxsm',
            'sm' => 'text-xsm',
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'default' => 'text-base',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            'h4' => 'text-h4'
        ];
    }

    /**
     * Допустимые веса шрифта
     *
     * @return string[]
     */
    protected function allowedTextWeights() {
        return [
            'default' => 'font-normal',
            'medium' => 'font-medium',
            'semibold' => 'font-semibold',
            'bold' => 'font-bold'
        ];
    }

    public function getTextColor() : string {
        return $this->getAllowedValue($this->color, $this->allowedTextColors(),
            $this->allowedTextColors()['default']);
    }

    public function getTextWeight() : string {
        return $this->getAllowedValue($this->weight, $this->allowedTextWeights(),
            $this->allowedTextWeights()['default']);
    }

    public function getTextSize() : string {
        return $this->getAllowedValue($this->size, $this->allowedTextSizes(),
            $this->allowedTextSizes()['default']);
    }

}
