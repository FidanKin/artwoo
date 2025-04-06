<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthorMain extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $author,
        public array $artworks,
        public array $userNavigation,
        public bool $isUserSelf,
        public string $backUrl = '/',
        public bool $canSendMessage = false,
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.author-main');
    }
}
