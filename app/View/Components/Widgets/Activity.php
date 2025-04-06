<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class Activity extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $padding = '',
        public string $margin = 'normal'
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
            'none' => ''
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
        return view('components.widgets.activity',
            [
                \App\View\Core\Interfaces\IndentInterface::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
            ]);
    }
}
