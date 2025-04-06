<?php

namespace App\View\Core\Interfaces;

/**
 * Интерфейс, который определяет данные для отображения во view
 */
interface ExportEntity
{
    /**
     * Получать данные сущности в виде массива
     *
     * @return array
     */
    public function exportForView(): array;

    /**
     * Собираем не всю сущность, а только его минимально необходимую часть
     *
     * @return array
     */
    public function exportForViewCompact(): array;
}
