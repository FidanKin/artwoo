<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelect extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name = 'multiple',
        public array $options = ['select' => ['a1' => 'fidan', 'a2' => 'kamil', 'a3' => 'ansar']],
        public string $placeholder = 'example text'
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.multi-select');
    }
}
