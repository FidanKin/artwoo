<?php

namespace Source\Lib\DTO;

class NavigationItemDTO
{
    public function __construct(
        public readonly string $path,
        public readonly string $title,
        public readonly bool $active = false,
        public readonly array $attributes = []
    ) {

    }
}
