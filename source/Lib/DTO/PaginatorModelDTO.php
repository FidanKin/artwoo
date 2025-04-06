<?php

namespace Source\Lib\DTO;

use Illuminate\Pagination\Paginator;

/**
 * Класс костыль, используется при построении постраничной навигации
 * Т.к. сейчас у нас при передаче модели в вью создается массив, куда вностя дополнительные ключ, например, изображения
 */
readonly class PaginatorModelDTO
{
    public function __construct(public Paginator $model, public array $mutationEntity)
    {

    }
}
