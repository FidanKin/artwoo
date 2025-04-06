<?php

namespace App\View\Core\Abstract;

use App\View\Core\Interfaces\BackgroundInterface;
use App\View\Core\Abstract\BaseAbstract;

/**
 * абстракный класс для работы с фоном
 */
abstract class BackgroundAbstract extends BaseAbstract implements BackgroundInterface  {
    public string $backgroundColor;

    /**
     * Есть ли у элемента фон
     *
     * @return bool
     */
    protected abstract function hasBg() : bool;

    protected function allowedBackgroundColors() {
        return [
            'black' => 'bg-black',
            'primary' => 'bg-primaryColor',
            'white' => 'bg-white',
            'base-gray' => 'bg-base-gray',
            'default' => ''
        ];
    }

    public function getBackgroundColor()
    {
        $backgroundColor = '';
        if ($this->hasBg()) {
            $backgroundColor = $this->getAllowedValue($this->backgroundColor, $this->allowedBackgroundColors(),
                $this->allowedBackgroundColors()['default']);
        }

        return $backgroundColor;
    }
}
