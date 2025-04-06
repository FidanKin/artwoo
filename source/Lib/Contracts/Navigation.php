<?php

namespace Source\Lib\Contracts;

use Source\Lib\DTO\NavigationItemDTO;

interface Navigation
{
    /**
     * @param NavigationItemDTO[] $defaultPath
     */
    public function __construct(array $defaultPath = []);

    /**
     * @return NavigationItemDTO[]
     */
    public function build(): array;

    public function add(NavigationItemDTO $item): static;
}
