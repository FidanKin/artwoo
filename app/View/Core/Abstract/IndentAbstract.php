<?php

namespace App\View\Core\Abstract;

use App\View\Core\Interfaces\IndentInterface;
use App\View\Core\Abstract\BaseAbstract;

/**
 * Абстрактный класс для работы с отсутпом
 */
abstract class IndentAbstract extends BaseAbstract implements IndentInterface  {
    public string $padding;
    public string $margin;

    protected function allowedPaddingClasses() {
        return IndentInterface::DEFAULT_PADDING_CLASSES;
    }

    protected function getDefaultPaddingClass() {
        return $this->allowedPaddingClasses()[0];
    }

    protected function getDefaultMarginClass() {
        return $this->allowedMarginClasses()[0];
    }

    protected function allowedMarginClasses() {
        return IndentInterface::DEFAULT_MARGIN_CLASSES;
    }

    public function getMarginClass()
    {
        return $this->getAllowedValue(
                $this->margin, $this->allowedPaddingClasses(),
                $this->getDefaultPaddingClass(), false
        );
    }

    public function getPaddingClass()
    {
        return $this->getAllowedValue(
                $this->padding, $this->allowedMarginClasses(),
                $this->getDefaultMarginClass(), false
        );
    }

    /**
     * Получение tailwind классов для передачи их в шаблон рендера
     *
     * @return string
     */
    protected function buildIndentClasses() : string {
        return $this->getPaddingClass() . ' ' . $this->getMarginClass() . ' ';
    }
}
