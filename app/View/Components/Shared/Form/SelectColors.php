<?php

namespace App\View\Components\Shared\Form;

use App\View\Core\Trait\FormAttributesBuilder;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectColors extends Component
{
    use FormAttributesBuilder;
    // пока размер влияет на высоту элемента
    private array $sizes = [
        'sm' => 'py-3',
        'normal' => 'py-3.75',
        'lg' => 'py-4'
    ];
    private array $bgcolors = [
        'normal' => 'bg-white',
        'sm-dark' => 'bg-slate-100',
        'dark-gray' => 'bg-base-gray'
    ];
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $elementData,
        public string $name = '',
        public string $placeholder = '',
        public array $options = [],
        public string $value = '',
        public bool $isActive = false,
        public string $size = 'normal',
        public string $bgColor = 'normal'
    ) {
        if (array_key_exists($this->bgColor, $this->bgcolors)) {
            $this->bgColor = $this->bgcolors[$this->bgColor];
        } else {
            $this->bgColor = $this->bgcolors['normal'];
        }

        $this->buildAttributes();

        if ( ! empty($this->value) && array_key_exists($this->value, $this->options['select'])) {
            $this->placeholder = $this->options['select'][$this->value];
        }
    }

    public function convertSizeToCss($size) {
        return $this->sizes[$size] ?? $this->sizes['normal'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.select-colors');
    }
}
