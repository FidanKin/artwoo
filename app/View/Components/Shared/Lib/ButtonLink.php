<?php

namespace App\View\Components\Shared\Lib;

use App\View\Components\Shared\Core\Link;

class ButtonLink extends Link
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $url,
        string $text,
        string $size = '',
        string $color = 'white',
        string $padding = 'btn-normal',
        string $margin = '',
        string $backgroundColor = 'primary',
        string $weight = 'medium',
        public string $borderColor = '',
        public string $borderRadius = 'full'
    )
    {
        parent::__construct($url, $text, $size, $color, false,
            $weight, $padding, $margin, $backgroundColor, false, true);
    }

    protected function allowedPaddingClasses(): array
    {
        return [
            'btn-normal' => 'py-3 px-8.5',
            'btn-sm-high' => 'py-3.5 px-8.5',
            'btn-md-high' => 'py-5.5 px-11'
        ];
    }

    protected function allowedBackgroundColors(): array
    {
        return [
            'black' => 'bg-black',
            'primary' => 'bg-primaryColor',
            'white' => 'bg-white',
            'default' => 'bg-primaryColor',
            'none' => 'bg-transparent',
            'primary-dark' =>  'bg-dark-blue',
        ];
    }

    protected function allowedBorderColors() {
        return [
            'black' => 'border-black',
            'primary' => 'border-primaryColor',
            'white' => 'border-white',
            'default' => 'border-primaryColor'
        ];
    }

    protected function allowedBorderRadiuses() {
        return [
            'full' => 'rounded-full',
            'default' => 'rounded-full'
        ];
    }

    /**
     * @inheritDoc
     */
    public function getBackgroundColor() : string
    {
        return $this->getAllowedValue($this->backgroundColor, $this->allowedBackgroundColors(),
            $this->allowedBackgroundColors()['default']);
    }

    public function getPaddingClass() : string
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
            '');
    }

    public function getBorderColor() : string {
        return $this->getAllowedValue($this->borderColor, $this->allowedBorderColors(),
                '');
    }

    public function getBorderRadius() : string {
        if (empty($this->backgroundColor) || empty($this->borderColor)) return '';

        return $this->getAllowedValue($this->borderRadius, $this->allowedBorderRadiuses(),
            $this->allowedBorderRadiuses()['default']);
    }

    protected function buildStyles(): string
    {
        $res = '';
        if ($this->getBorderColor()) {
            // это стилизованная кнопка только с бордер, hover ей не нужен
            $this->hoverClasses = '';
            $res .= "{$this->getBorderColor()} ";
            $res .= "border-2 ";
        }
        $res .= parent::buildStyles();
        $res .= $this->getBorderRadius();
        return $res;
    }

    protected function allowedMarginClasses(): array
    {
        return parent::allowedMarginClasses();
    }

}
