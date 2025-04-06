<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\View\Core\Trait\FormAttributesBuilder;

class Textarea extends Component
{
    use FormAttributesBuilder;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $elementData,
        public string $name = '',
        public string $value = '',
        public string $placeholder = '',
        public string $bgColor = 'white',
        public int $rows = 11
    )
    {
        $this->buildAttributes();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.textarea');
    }
}
