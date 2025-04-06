<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitInput extends Component
{
    private array $sizes = [
        'xsm' => 'py-1 px-6',
        'sm' => 'py-2 px-6',
        'base' => 'py-4 px-10',
        'lg' => 'py-6 px-6'
    ];
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $text = 'Отправить',
        public bool $isDark = false,
        public bool $isFullWidth = true,
        public bool $includeMt = false, // добавить ли margin-top
        public string $size = 'normal',
        public string $form = '',
    ) {

    }

    private function getSize() {
        return array_key_exists($this->size, $this->sizes) ?
            $this->sizes[$this->size] : $this->sizes['base'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.submit-input', ['elSize' => $this->getSize()]);
    }
}
