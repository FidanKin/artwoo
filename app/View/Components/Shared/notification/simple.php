<?php

namespace App\View\Components\shared\notification;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use function Source\Lib\FormState\artwooSessionResolveStateColor;

class simple extends Component
{
    public string $messageColors;
    public string $buttonTextColors;
    public string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $message,
        private readonly string $state = 'success'
    )
    {
        $this->id = Str::uuid();
        $mainColor = artwooSessionResolveStateColor($this->state);
        $this->messageColors = "text-{$mainColor}-800 bg-{$mainColor}-50";
        $this->buttonTextColors = "text-{$mainColor}-500 focus:ring-{$mainColor}-400 hover:bg-{$mainColor}-200";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.notification.simple');
    }
}
