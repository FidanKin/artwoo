<?php

namespace App\View\Components\shared\core;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\TextAdvAbstract;

class Link extends TextAdvAbstract
{
    protected string $hoverClasses = 'hover:bg-black';
    /**
     * Инстанс ссылки
     *
     * @param string $url - пусть ссылки
     * @param string $text - текст ссылки
     * @param string $size - размер текста ссылки
     * @param bool $active - активная ли кнопка
     * @param string $weight - вес текста
     * @param string $padding - внутренний отсутп
     * @param string $margin - внешний отступ
     * @param string $backgroundColor - цвета фона
     * @param bool $underline - нижнее подчеркивание
     * @param bool $isButton - ссылка как кнопка (с отступами, цветом фона)
     */
    public function __construct(
        public string $url,
        public string $text,
        public string $size = 'normal',
        public string $color = 'black',
        public bool $active = false,
        public string $weight = 'default',
        public string $padding = '',
        public string $margin = '',
        public string $backgroundColor = '',
        public bool $underline = false,
        public bool $isButton = false
    )
    {
        if ( ! $this->isButton ) {
            // сбрасываем свойства, которые относятся к ссылке кнопке
            $this->backgroundColor = '';
            $this->padding = '';
            $this->margin = '';
            $this->hoverClasses = '';
        }
    }

    protected function buildStyles() : string {
        $res = $this->getTextWeight() . '  ';
        $res .= $this->getTextSize() . '  ';
        $res .= $this->getBackgroundColor() . ' ';
        $res .= $this->getMarginClass() . ' ';
        $res .= $this->getPaddingClass() . ' ';
        $res .= $this->hoverClasses . ' ';
        if ($this->active) {
            $res .= 'text-primaryColor ';
        } else {
            $res .= $this->getTextColor() . " ";
        }

        return $res;
    }

    /**
     * @inheritDoc
     *
     * @return string[]
     */
    protected function allowedTextSizes(): array
    {
        return [
            'small' => 'text-xs',
            'normal' => 'text-xs',
            'big' => 'text-xll',
            'default' => 'text-sm'
        ];
    }

    protected function allowedMarginClasses() : array
    {
        return [''];
    }

    protected function allowedPaddingClasses() : array
    {
        return [''];
    }

    protected function allowedBackgroundColors() : array
    {
        return [''];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.core.link', ['styleClasses' => $this->buildStyles()]);
    }
}
