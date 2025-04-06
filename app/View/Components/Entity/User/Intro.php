<?php

namespace App\View\Components\Entity\User;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\IndentAbstract;
use App\View\Core\Interfaces\BackgroundInterface;
use Source\Helper\Enums\FormElementsFormat;

class Intro extends IndentAbstract implements BackgroundInterface
{
    private string $sendMessageButtonBackground = 'black';
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $padding = '',
        public string $margin = '',
        public string $backgroundColor = ''
    ) {
        if ($this->backgroundColor === 'white') {
            $this->sendMessageButtonBackground = 'primary';
        }

    }

    protected function allowedPaddingClasses()
    {
        return [
            'normal' => 'p-2.5',
        ];
    }

    /**
     * Разрешение цвета для фона
     *  По умолчанию 'none'
     *
     * @return array
     */
    protected function allowedBackgroundClasses() : array {
        return [
            'white' => 'bg-white',
            'none' => ''
        ];
    }

    public function getPaddingClass()
    {
        return $this->getAllowedValue($this->padding, $this->allowedPaddingClasses(),
            $this->allowedPaddingClasses()['normal']);
    }

    public function getMarginClass()
    {
        return '';
    }

    public function getBackgroundColor()
    {
        return $this->getAllowedValue($this->backgroundColor, $this->allowedBackgroundClasses(),
            $this->allowedBackgroundClasses()['none']);
    }

    private function buildStyles() : string {
        return $this->buildIndentClasses() . ' ' . $this->getBackgroundColor() . ' ';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity.user.intro', [
                'styleClasses' => $this->buildStyles(),
                'buttonBackground' => $this->sendMessageButtonBackground,
                'chatForm' => [
                  'name' => 'message',
                  'placeholder' => __("chat.message"),
                  'value' => '',
                  'options' => [],
                  'type' => FormElementsFormat::TEXT, 'required',
                ],
            ]
        );
    }
}
