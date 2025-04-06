<?php

namespace Source\Lib\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Интерфейс для применения фильтрации к модели из запроса по GET параметрам
 * @see https://laravel.com/docs/11.x/eloquent#utilizing-a-local-scope
 */
interface ModelFilterFromRequest
{
    /**
     * Выполнение фильтрации согласно переданным параметрам
     *
     * @param Builder $query - построитель запроса
     * @param array $requestParams - массив в формате ключ => значение
     * @return void
     */
    public function scopeFilter(Builder $query, array $requestParams): void;
}
