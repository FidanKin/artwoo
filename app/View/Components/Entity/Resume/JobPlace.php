<?php

namespace App\View\Components\Entity\Resume;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class JobPlace extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $padding = 'normal',
        public string $margin = ''
    )
    {
        //
    }

    protected function allowedPaddingClasses()
    {
        return [
            'normal' => 'py-6',
            'sm' => '',
            'md' => '',
        ];
    }

    public function getMarginClass()
    {
        return '';
    }

    public function getPaddingClass()
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
            $this->allowedPaddingClasses()['normal']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity.resume.job-place',
        [
            \App\View\Core\Interfaces\IndentInterface::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
