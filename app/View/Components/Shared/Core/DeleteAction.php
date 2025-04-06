<?php

namespace App\View\Components\shared\core;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * При клике по компоненту должна появляться всплывашка для подтверждения действия пользователя
 * Например, удаление пользователя
 */
class DeleteAction extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text,
        public string $url,
        public string $content,
        public string $id
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.core.delete-action');
    }
}
