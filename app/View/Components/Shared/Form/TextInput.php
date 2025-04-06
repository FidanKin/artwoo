<?php

namespace App\View\Components\Shared\Form;

use App\View\Core\FormElementConst;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\View\Core\Trait\FormAttributesBuilder;

class TextInput extends Component
{
    use FormAttributesBuilder;
    private array $bgcolors = [
        'normal' => 'bg-white',
        'sm-dark' => 'bg-slate-100',
    ];
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $elementData,
        public string $name = '',
        public string $placeholder = '',
        public string $bgColor = 'normal',
        public string $value = '', // значение инпута
        public array $options = [],
        public string $state = FormElementConst::STATE_ACTIVE
    ) {
        if (array_key_exists($this->bgColor, $this->bgcolors)) {
            $this->bgColor = $this->bgcolors[$this->bgColor];
        } else {
            $this->bgColor = $this->bgcolors['normal'];
        }

        $this->buildAttributes();
        if (isset($this->options['state'])) {
            $this->state = $this->options['state'];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.text-input');
    }
}
