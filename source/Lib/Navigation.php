<?php

namespace Source\Lib;

use Source\Lib\DTO\NavigationItemDTO;

class Navigation implements \Source\Lib\Contracts\Navigation
{
    /**
     * @var NavigationItemDTO[] $items
     */
    protected array $items = [];
    public function __construct(array $defaultPath = [])
    {
        foreach ($defaultPath as $item) {
            $this->items[] = $item;
        }
    }

    public function add(NavigationItemDTO $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    public function build(): array
    {
        return $this->items;
    }

    /**
     * Добавить навигацию к моей странице
     *
     * @return $this
     */
    public function addMyNode(): static {
        $this->items[] = new NavigationItemDTO('/my', __('user.navigation.my_page'));
        return $this;
    }
}
