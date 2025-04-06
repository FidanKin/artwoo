<?php

namespace App\View\Components\Entity\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Nav extends Component
{
    private array $links = [
        'artworks' => 'Работы',
        'resume' => 'Резюме',
        'profile' => 'Профиль'
    ];
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $activeLink = '' // какая из ссылок активна
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity.user.nav', [
            'links' => $this->links
        ]);
    }
}
