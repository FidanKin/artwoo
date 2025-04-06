<?php

namespace App\View\Components\Shared\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\View\Core\Trait\FormAttributesBuilder;
use Source\Helper\Enums\FormElementsFormat;

/**
 * @todo Вместо того, чтобы создать два элемента формы filepicker для добавления
 * preview и остальных изображений нужно обходиться одним элементом, где можно выбрать
 * главное изображение для превьюх.
 */
class Filepicker extends Component
{
    use FormAttributesBuilder;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $elementData,
        public string $name = '',
        public string $value = '',
        public FormElementsFormat $type = FormElementsFormat::FILE,
        public string $placeholder = '',
        public array $options = [],
        public bool $multiple = true,
        public string $inputName = '',
    ) {
        $this->buildAttributes();

        $this->inputName = $this->name;

        if (empty($this->placeholder)) {
            $this->placeholder = trans('core.actions.upload');
        }

        if ($this->multiple) {
            $this->inputName = $this->name . '[]';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.filepicker');
    }
}
