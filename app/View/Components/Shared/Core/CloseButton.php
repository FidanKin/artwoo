<?php

namespace App\View\Components\shared\core;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Source\Lib\AppLib;

class CloseButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public bool $returnBack = true, public string $backUrl = '')
    {
        if (empty($this->backUrl)) {
            $this->backUrl = AppLib::backUrl();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.core.close-button');
    }
}
