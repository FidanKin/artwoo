<?php

namespace App\View\Core\Interfaces;

/**
 * Интерфейс для работы с отступами
 */
interface IndentInterface {

    /**
     * Ключ, котоырй может быть использовать при передаче классов
     *  отступа tailwind в компонент view
     *
     * @example view('core.lib.item', [
     *      IndentInteface::DEFAULT_STYLES_KEY => $this->getIndentStyles
     *  ])
     */
    const DEFAULT_STYLES_KEY = 'indentStyles';
    const DEFAULT_PADDING_CLASSES = [
        'p-px', 'pt-px', 'p-1', 'px-1', 'py-1', 'p-1.5', 'px-1.5', 'py-1.5',
        'p-2', 'px-2', 'py-2', 'p-2', 'px-2', 'py-2',  'p-3.5', 'px-3.5', 'py-3.5',
        'p-6', 'px-6', 'py-6', 'p-8', 'px-8', 'py-8',
    ];

    const DEFAULT_MARGIN_CLASSES = [
        'm-px','mt-px', 'm-1', 'mx-1', 'my-1', 'm-1.5', 'mx-1.5', 'my-1.5',
        'm-2', 'mx-2', 'my-2', 'm-2', 'mx-2', 'my-2',  'm-3.5', 'mx-3.5', 'my-3.5',
        'm-6', 'mx-6', 'my-6', 'm-8', 'mx-8', 'my-8'
    ];

    /**
     * Получение класса (tailwind) внутреннего отступа
     */
    public function getPaddingClass();

    /**
     * получение класса (tailwind) внешнего отсутпа
     */
    public function getMarginClass();
}
