<?php

namespace App\View\Components\Shared\Form;

use App\View\Core\Trait\FormAttributesBuilder;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordInput extends Component
{
    use FormAttributesBuilder;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $elementData,
        public string $placeholder = '',
        public string $name = ''
    )
    {
        $this->buildAttributes();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.password-input');
    }
}
