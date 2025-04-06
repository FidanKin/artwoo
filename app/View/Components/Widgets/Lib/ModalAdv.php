<?php

namespace App\View\Components\Widgets\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalAdv extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $description,
        public ?string $attentiontext = null,
        public ?string $actiontext = null
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.lib.modal-adv');
    }
}
