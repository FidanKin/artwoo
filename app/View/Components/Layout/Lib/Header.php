<?php

namespace App\View\Components\Layout\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Source\Entity\User\Models\User;

class Header extends Component
{
    public ?User $user; // текущий пользователь

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.lib.header');
    }
}
