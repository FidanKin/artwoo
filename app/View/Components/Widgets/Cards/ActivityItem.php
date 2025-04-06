<?php

namespace App\View\Components\Widgets\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $content,
        public string $buttontext,
        public string $details,
        public string $status = '',
        public string $subtitle = '',

    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.cards.activity-item');
    }
}
