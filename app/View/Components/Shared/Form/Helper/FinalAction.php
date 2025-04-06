<?php

namespace App\View\Components\Shared\Form\Helper;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FinalAction extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $deleteText,
        public string $saveText,
        public string $content,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.helper.final-action');
    }
}
