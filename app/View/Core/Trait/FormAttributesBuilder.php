<?php

namespace App\View\Core\Trait;

/**
 * трейт помощник, который удобно организуем атрибуты для компонента формы
 * В компонент формы передаем все атрибуты для элемента формы, а трейт уже изменяет существуюшие атрибы на атрибуты из даты
 */
trait FormAttributesBuilder
{
    private array $allowedFieldsOptions = [
        'name', 'value', 'type', 'placeholder', 'options'
    ];
    private function buildAttributes(): void {
        foreach ($this->allowedFieldsOptions as $allowed) {
            if (empty($this->{$allowed}) && !empty($this->elementData[$allowed])) {
                $this->{$allowed} = $this->elementData[$allowed];
            }
        }
    }
}
