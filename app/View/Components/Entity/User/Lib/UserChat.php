<?php

namespace App\View\Components\Entity\User\Lib;

use App\View\Core\Abstract\TextAbstract;
use Closure;
use Illuminate\Contracts\View\View;

class UserChat extends TextAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $login, // логин пользователя
        public string $icon, // место до иконки в файловой зоне
        public string $status,
        public int $messagecount = 0,
        public bool $reverse = false,
        public string $size = 'h4',
        public string $color = 'none',
        public string $weight = 'normal',
        public bool $enablelogin = true,
        public string $cardsize = 'normal'
    )
    {
        $this->text = $login;
    }

    /**
     * Получаем класс, если нужно отобразить инфу о пользователе слева
     *
     * @return string
     */
    private function getReverseClass() : string {
        if ($this->reverse) {
            return 'flex-row-reverse';
        }
        return '';
    }

    public function getIconSize() : string {
        $sizes = [
            'normal' => 'w-[41px] h-[41px]',
            'mini' => 'w-[21px] h-[21px]'
        ];

        return $sizes[$this->cardsize] ?? $sizes['normal'];
    }

    public function getStatusSize() : string {
        $sizes = [
            'normal' => 'text-sm',
            'mini' => 'text-xsm'
        ];

        return $sizes[$this->cardsize] ?? $sizes['normal'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity.user.lib.user-chat', [
                'icon' => $this->icon,
                'reversedirection' => $this->getReverseClass(),
                self::DEFAULT_TEXT_STYLES_KEY => $this->getTextSize()
            ]
        );
    }
}
