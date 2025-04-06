<?php

namespace App\View\Core\Abstract;

abstract class TextAdvAbstract extends TextAbstract
    implements \App\View\Core\Interfaces\BackgroundInterface,
            \App\View\Core\Interfaces\IndentInterface
{
    public string $backgroundColor;
    public string $padding;
    public string $margin;

    protected abstract function allowedBackgroundColors() : array;

    protected abstract function allowedPaddingClasses() : array;

    protected abstract function allowedMarginClasses() : array;

    /**
     * @inheritDoc
     */
    public function getBackgroundColor() : string
    {
        return $this->getAllowedValue($this->backgroundColor, $this->allowedBackgroundColors(),
            $this->allowedBackgroundColors()[0], false);
    }

    /**
     * Получение классов внутреннего отступа
     *
     * @return string
     */
    public function getPaddingClass() : string
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
                '', false);
    }

    /**
     * Внешний отступ задается в виде массива, поэтому
     *  проходимся по массиву и собираем результат в строку
     *
     * @return string
     */
    public function getMarginClass() : string
    {
        return $this->getAllowedValue($this->margin, $this->allowedMarginClasses(),
                    '', false);
    }

}
