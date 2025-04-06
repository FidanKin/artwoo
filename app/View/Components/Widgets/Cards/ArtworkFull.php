<?php

namespace App\View\Components\Widgets\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArtworkFull extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $artwork
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.cards.artwork-full');
    }
}
