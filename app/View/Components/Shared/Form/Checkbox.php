<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;
use App\View\Core\Trait\FormAttributesBuilder;

class Checkbox extends Component
{
    use FormAttributesBuilder;
    public string $id;
    /**
     * @param string $name - input name
     */
    public function __construct(
        public array $elementData,
        public string $name = '',
        public string $placeholder = '',
        public bool $value = false,
        public array $options = [],
        public bool $bgwhite = true
    ) {
        $this->id = (string) Str::uuid();
        $this->buildAttributes();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.checkbox');
    }
}
