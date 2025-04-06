<?php

namespace App\View\Components\Entity\User\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\View\Core\Abstract\TextAbstract;

class UserInfo extends TextAbstract
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $login, // логин пользователя
        public int $id,
        public string $icon, // место до иконки в файловой зоне
        public string $artworktype = '', // главный тип работ пользователя
        public bool $moreinfo = true,
        public string $age = '', // возраст
        public bool $reverse = false,
        public string $loginFontSize = 'normal',
        public string $size = 'h4',
        public string $color = 'none',
        public string $weight = 'normal',
        public array $socials = [],

    )
    {
        $this->text = $login;
        //
    }

    /**
     * Получаем полный url до иконки пользователя
     */
    private function getFullIconUrl() {
        return config('app.url') . ':8000/' . $this->icon;
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

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity.user.lib.user-info', [
            'iconfullurl' => $this->getFullIconUrl(),
            'reversedirection' => $this->getReverseClass(),
            self::DEFAULT_TEXT_STYLES_KEY => $this->getTextSize()
            ]
        );
    }
}
