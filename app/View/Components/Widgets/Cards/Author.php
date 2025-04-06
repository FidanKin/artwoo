<?php

namespace App\View\Components\Widgets\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class Author extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        // user as array
        public array $author,
        // user artworks with one image in each artwork
        public array $artworks,
        public string $padding = 'normal',
        public string $margin = ''
    )
    {
        //
    }

    protected function allowedPaddingClasses()
    {
        return [
            'normal' => 'py-1.5 px-5',
            'none' => ''
        ];
    }

    public function getPaddingClass()
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
            $this->allowedPaddingClasses()['normal']);
    }

    public function getMarginClass()
    {
        return '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.cards.author', [
            self::DEFAULT_STYLES_KEY => $this->buildIndentClasses()
        ]);
    }
}
