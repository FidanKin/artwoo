<?php

namespace App\View\Components\Shared\Lib\Collections;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tags extends Component
{
    /**
     * Create a new component instance.
     * @see \App\View\Components\shared\lib\items\tag
     */
    public function __construct(
        public string $bgcolor = 'gray',
        public array $taglist = [], // список тегов
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.lib.collections.tags');
    }
}
