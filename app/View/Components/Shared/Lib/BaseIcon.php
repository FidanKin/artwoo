<?php

namespace App\View\Components\Shared\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\BackgroundAbstract;
/**
 * Круглая иконка с цветом фона и заданным изображением, расположенным по центру
 */
class BaseIcon extends BackgroundAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $iconurl, // путь до картинки
        public string $padding = 'p-2', // отступ
        public string $width = 'w-8', // ширина
        public string $height = 'h-8', // выстота
        public string $backgroundColor = 'primary',
        public string $filter = ''
    )
    {
        //
    }

    protected function allowedBackgroundColors()
    {
        return array_merge(parent::allowedBackgroundColors(), ['transparent' => 'bg-transparent']);
    }

    protected function hasBg(): bool
    {
        return true;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.lib.base-icon', [
            self::DEFAULT_BACKGROUND_STYLES_KEY => $this->getBackgroundColor()
        ]);
    }
}
