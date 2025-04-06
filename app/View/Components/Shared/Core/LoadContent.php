<?php

namespace App\View\Components\shared\core;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoadContent extends Component
{
    public string $text;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $darkBg = false
    )
    {
        //
        $this->text = __('core.load_more');
    }

    private function getBgColor() {
        return $this->darkBg === true ? 'bg-dark-gray' : 'bg-white';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.core.load-content', ['bgColor' => $this->getBgColor()]);
    }
}
