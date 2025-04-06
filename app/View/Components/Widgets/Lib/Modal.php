<?php

namespace App\View\Components\Widgets\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Spatie\Backtrace\Arguments\Reducers\StdClassArgumentReducer;

class Modal extends Component
{
    public bool $hasAction = false;

    /**
     * @param string $id - идентификатор модалки
     * @param string $title - заголовок модалки
     * @param string $content - основной текст в самой моделке (body)
     * @param string $closeText - текст кнопки закрытия модального окна (по умолчанию "Закрыть")
     * @param string $method - метоод запрос
     * @param string $actionUrl - ссылка для перенаправления
     * @param string $actionLabel - текст для активного действия
     *
     */
    public function __construct(
        public string $id,
        public string $title,
        public string $content,
        public string $closeText = '',
        public string $method = 'POST',
        public string $actionUrl = '',
        public string $actionLabel = ''
    )
    {
        if (empty($closeText)) {
            $this->closeText = __("core.actions.close");
        }
        if (!empty($actionUrl) && !empty($actionLabel)) {
            if (empty($this->method)) $this->method = 'POST';
            $this->hasAction = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.lib.modal');
    }
}
