<?php

namespace Source\Lib;

/**
 * DTO объект тега, который может использоваться во всей системе
 */
readonly class TagDTO
{
    /**
     * @param string $text - отображаемый текст
     * @param string $slag - уникальное название тега, по которому будет происходить поиск
     * @param string $query - строка запроса, например, ?topic or &topic
     * @param bool $isActive - активен ли тег
     */
    public function __construct(public string $text, public string $slag, public string $query, public bool $isActive = false)
    {
        // empty
    }
}
