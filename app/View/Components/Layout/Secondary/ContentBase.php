<?php

namespace App\View\Components\Layout\Secondary;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;

class ContentBase extends IndentAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $padding = 'normal',
        public string $margin = '',
        public string $title = '',
        public bool $isViewSingleItem = false,
        public bool $canManage = false,
        public bool $isEditable = false,
        public string $headerSlot = '',
        public array $actions = [], // пути на совершение действий
        public string|bool $backUrl = false, // ссылка перехода к предыдущей странице (закрывающая иконка)
    ) {
        //
    }

    protected function allowedPaddingClasses()
    {
        return [
            'normal' => 'pt-5 pb-20 max-md:pt-4 max-md:pb-10',
            'default' => 'pt-5 pb-20 max-md:pt-4 max-md:pb-10',
            'md' => '',
            'sm' => '',
            'none' => ''
        ];
    }

    public function getPaddingClass()
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
            $this->allowedPaddingClasses()['default']);
    }

    public function getMarginClass()
    {
        return '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.secondary.content-base',
        [
            'indentStyles' => $this->buildIndentClasses()
        ]);
    }
}
