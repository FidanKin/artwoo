<?php

namespace App\View\Components\Shared\Lib\Items;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Source\Lib\TagDTO;

class Tag extends Component
{
    private $bgcolortypes = [
        'gray' => '[#E8EDEE]', 'primary' => 'primaryColor', 'black' => 'black', 'white' => 'white',
        'sm-gray' => 'sm-gray'
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public TagDTO $tag,
        public string $bgcolor = 'gray',
        public bool $isLink = true,
        public bool $isActive = false,
    )
    {
        //
    }

    /**
     * получаем конечный класс для цвета фона
     */
    private function getBgClass() {
        if ( ! in_array($this->bgcolor, array_keys($this->bgcolortypes))) {
            return "bg-white";
        }

        return 'bg-' . $this->bgcolortypes[$this->bgcolor];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.lib.items.tag', ['bgcolorclass' => $this->getBgClass()]);
    }
}
