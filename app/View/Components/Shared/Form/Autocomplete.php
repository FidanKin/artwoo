<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\View\Core\Trait\FormAttributesBuilder;

class Autocomplete extends Component
{
    use FormAttributesBuilder;
    private array $bgcolors = [
        'normal' => 'bg-white',
        'sm-dark' => 'bg-slate-100',
    ];

    public string $defaultTags = '';
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $elementData,
        public string $name = '',
        public string $placeholder = '',
        public string $bgColor = 'normal',
        public string $value = '', // значение инпута
        public array $options = []
    )
    {
        if (array_key_exists($this->bgColor, $this->bgcolors)) {
            $this->bgColor = $this->bgcolors[$this->bgColor];
        } else {
            $this->bgColor = $this->bgcolors['normal'];
        }
        $this->buildAttributes();
        if (!empty($this->options['default_tags'])) {
            $this->defaultTags = implode(',', $this->options['default_tags']);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.autocomplete');
    }
}
