<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class ResumeEditForm extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $formid,
        public array $formData,
        public string $padding = '',
        public string $margin = 'normal',
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


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.resume-edit-form', [
            self::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
