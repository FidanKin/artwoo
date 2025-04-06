<?php

namespace App\View\Components\Entity\User;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class ContentNavigation extends IndentAbstract
{
    public array $navigationNodes = [];
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $userNavigation,
        public string $padding = '',
        public string $margin = 'normal'
    )
    {
        $this->navigationNodes = $this->userNavigation;
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
        return view('components.entity.user.content-navigation',
        [
            \App\View\Core\Interfaces\IndentInterface::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
