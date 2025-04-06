<?php

namespace App\View\Components\Widgets\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class Recommendation extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $image = true,
        public bool $availability = true,
        public string $padding = 'normal',
        public string $margin = ''
    )
    {
        //
    }

    protected function allowedPaddingClasses()
    {
        return [
          'normal' => 'p-2.75',
          'none' => ''
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
        return view('components.widgets.cards.recommendation', [
            self::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
