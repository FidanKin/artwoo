<?php

namespace App\View\Components\Shared\Core;

use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\TextAbstract;

class Title extends TextAbstract
{
    // размеры текста
    protected function allowedTextSizes(): array
    {
        return [
            'h1' => '1',
            'h2' => 'text-h2',
            'h3' => 'text-h3',
            'h4' => 'text-base',
            'h5' => 'text-sm',
            'default' => 'text-h2'
        ];
    }

    /**
     * Получение допустимых цветов для текста
     *
     * @return string[]
     */
    protected function allowedTextColors(): array
    {
        return [
            'white' => 'text-white',
            'black' => 'text-black',
            'primary' => 'text-primaryColor',
            'default' => 'text-white',
            'gray' => 'text-gray',
            'multi' => 'bg-clip-text text-transparent bg-gradient-to-r from-primaryColor to-orange-400',
        ];
    }

    /**
     * Получение тега для заголовка (h1 - h6)
     *
     * @return string
     */
    private function getTitleTag(): string
    {
        if (array_key_exists($this->size, $this->allowedTextSizes()) && $this->size !== 'default') {
            return $this->size;
        }

        return 'h2';
    }
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text,
        public string $size = 'h2',
        public string $color = 'black',
        public string $containerClasses = '',
        public string $weight = 'default',
    ) {

    }

    /**
     * получение стилей для заголовка
     * можно в родитеский див пропихивать классы и тогда ок
     *
     * @todo font-weight для h работает некорректно
     *
     * @return string
     */
    public function titleStyles() : string
    {
        return " {$this->getTextSize()} {$this->getTextWeight()} {$this->getTextColor()} ";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.shared.core.title', [
            'titleClasses' => $this->titleStyles(),
            'titleSize' => $this->getTitleTag()
        ]);
    }
}
