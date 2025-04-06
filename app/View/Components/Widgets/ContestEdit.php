<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class ContestEdit extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $formId = 'contest-item-edit',
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
            'normal' => 'mb-9',
            'none' => ''
        ];
    }

    public function getMarginClass()
    {
        return $this->getAllowedValue($this->margin, $this->allowedMarginClasses(),
            $this->allowedMarginClasses()['normal']);
    }

    private function getInfoList() {
        return [
                'Максимальное количество работ: 3',
                'Приз за участие: 2000 руб'
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.contest-edit', [
            'infolist' => $this->getInfoList(),
            \App\View\Core\Interfaces\IndentInterface::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
