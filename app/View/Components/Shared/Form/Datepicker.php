<?php

namespace App\View\Components\Shared\Form;

use App\View\Core\Trait\FormAttributesBuilder;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Datepicker extends Component
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
        public string $placeholder = '',
        public string $name = '',
        public string $bgColor = 'normal',
        public string $value = '',
        public array $options = [],
    ) {
        if (array_key_exists($this->bgColor, $this->bgcolors)) {
            $this->bgColor = $this->bgcolors[$this->bgColor];
        } else {
            $this->bgColor = $this->bgcolors['normal'];
        }
        $this->buildAttributes();
    }

    private function generateId(): string
    {
        return Str::uuid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.datepicker', ['id' => $this->generateId()]);
    }
}
