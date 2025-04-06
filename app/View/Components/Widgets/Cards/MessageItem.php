<?php

namespace App\View\Components\Widgets\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\View\Core\Abstract\BackgroundAbstract;

class MessageItem extends BackgroundAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $messagetext,
        public string $userIcon,
        public string $createdAt,
        public bool $owner = false,
        public string $backgroundColor = '',
    )
    {
        //
    }

    protected function allowedBackgroundColors()
    {
        return array_merge(parent::allowedBackgroundColors(), ['light-gray' => 'bg-light-gray']);
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
        return view('components.widgets.cards.message-item', [
            self::DEFAULT_BACKGROUND_STYLES_KEY => $this->getBackgroundColor()
        ]);
    }
}
