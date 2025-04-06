<?php

namespace App\View\Components\Entity\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class DescriptionBase extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $padding = '',
        public string $margin = 'normal',
        public string $description = ''
    )
    {
        //
    }

    public function getPaddingClass()
    {
        return '';
    }

    protected function allowedMarginClasses()
    {
        return [
            'normal' => 'my-4',
            'sm' => '',
            'md' => '',
        ];
    }

    public function getMarginClass()
    {
        return $this->getAllowedValue($this->margin, $this->allowedMarginClasses(),
            $this->allowedMarginClasses()['normal']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity.lib.description-base', [
            \App\View\Core\Interfaces\IndentInterface::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
