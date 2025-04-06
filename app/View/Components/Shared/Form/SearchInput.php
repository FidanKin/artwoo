<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\InputAbstract;

class SearchInput extends InputAbstract
{
    public string $filterSize = 'normal';
    public string $submitsize = 'sm';
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $fullWidth = false,
        public string $searchInputColor = 'gray',
        public string $inputSize = 'normal',
        public bool $enablefilter = true,
        public array $searches = [],
    ) {
        if ($this->inputSize !== 'normal') {
            $this->filterSize = 'sm';
            $this->submitsize = 'xsm';
        }
    }

    protected function allowedInputSizes()
    {
        return [
            'normal' => 'py-2',
            'sm' => '',
            'none' => ''
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.search-input', [
            self::INPUT_SIZE_CLASSES_KEY => $this->getInputSize()
        ]);
    }
}
