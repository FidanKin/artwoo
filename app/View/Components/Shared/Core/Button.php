<?php

namespace App\View\Components\shared\core;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\TextAdvAbstract;

class Button extends TextAdvAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text,
        public string $size = 'normal',
        public string $color = 'normal',
        public string $padding = 'normal',
        public string $margin = 'none',
        public string $backgroundColor = 'primary',
        public string $weight = 'default',
        public string $buttonID = '',
        public bool $fullWidth = false,
    ) {

    }

    protected function allowedMarginClasses(): array
    {
        return [];
    }

    protected function allowedPaddingClasses(): array
    {
        return [
            'normal' => 'px-6 py-4',
            'sm' => 'px-6 py-3.5',
            'md' => 'px-8 py-5.5'
        ];
    }

    protected function allowedBackgroundColors(): array
    {
        return [
            'primary' => 'bg-primaryColor',
            'black' => 'bg-black',
            'dark-blue' => 'bg-dark-blue'
        ];
    }

    protected function buildStyles() : string {
        $res = $this->getTextWeight() . '  ';
        $res .= $this->getTextSize() . '  ';
        $res .= $this->getBackgroundColor() . ' ';
        $res .= $this->getMarginClass() . ' ';
        $res .= $this->getPaddingClass() . ' ';
        $res .= $this->getTextColor() . ' ';

        if ($this->fullWidth) {
            $res .= ' w-full ';
        }

        return $res;
    }

    public function getMarginClass(): string
    {
        return '';
    }

    public function getBackgroundColor(): string
    {
        return $this->getAllowedValue($this->backgroundColor, $this->allowedBackgroundColors(),
            $this->allowedBackgroundColors()['primary']);
    }

    public function getPaddingClass(): string
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
            $this->allowedPaddingClasses()['normal']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.core.button', [
            'buttonStyles' => $this->buildStyles()
        ]);
    }
}
