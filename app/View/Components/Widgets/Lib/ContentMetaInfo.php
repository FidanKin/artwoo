<?php

namespace App\View\Components\Widgets\Lib;

use App\View\Core\Components\ContentMetaInfo\MainInfo;
use App\View\Core\Components\ContentMetaInfo\SecondaryInfo;
use App\View\Core\Components\ContentMetaInfo\TagInfo;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentMetaInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\View\Core\Components\ContentMetaInfo\ContentMetaInfo $metaInfo
    ) {

    }

    /**
     * Получение конечной строки, которая будет поставлена в интерфейс
     *  мета информации контента
     */
    private function getMaininfo() : string
    {
        $res = '';
        $metaInfo = $this->metaInfo[new MainInfo()];
        if (empty($metaInfo)) return $res;
        $maxiter = count($metaInfo);
        for ($i = 0; $i < $maxiter; $i++) {
            $res .= $this->getItemAsSpan($metaInfo[$i]);
            if ($maxiter > 1 && $i != $maxiter - 1) {
                $res .= ' / ';
            }
        }

        return $res;
    }

    /**
     * Возможно, эту логику можно реализовать во view уже в шаблоне
     * Чтоб вызывать нужные шаблон и подставить в него данные
     *
     * Или так: https://laracasts.com/discuss/channels/laravel/how-call-a-component-in-a-controller
     */
    private function getSecondaryInfo(): string
    {
        $res = '';
        $secondaryInfo = $this->metaInfo[new SecondaryInfo()];
        if (empty($secondaryInfo)) return $res;
        foreach($secondaryInfo as $item) {
            $textColor = 'text-black';
            switch($item['type']) {
                case 'icon':
                    $url = url($item['value']);
                    $res .= "<img src='{$url}' />";
                    break;
                case 'text':
                    if (isset($item['color']) && $item['color'] === 'gray') {
                        $textColor = 'text-sm-gray';
                    }
                    $res .= "<span class=\"text-xs font-medium $textColor\">{$item['value']}</span>";
                    break;
            }

        }
        return $res;
    }

    private function getItemAsSpan(array $item): string
    {
        $bold = '';

        if (empty($item['value'])) return '';

        if ($item['isbold'] === true) {
            $bold = 'font-bold';
        }

        return "<span class=\"text-xs $bold\">{$item['value']}</span>";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.lib.content-meta-info', [
            'maininfodisplay' => $this->getMaininfo(),
            'secondaryinfodisplay' => $this->getSecondaryInfo(),
            'tag' => $this->metaInfo[new TagInfo()]
        ]
        );
    }
}
