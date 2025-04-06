<?php

namespace App\View\Core\Components\ContentMetaInfo;

class MainInfo implements MainInfoInterface
{
    private array $container = [];
    public function getValueForRender(): array
    {
        return $this->container;
    }

    public function add(mixed $attribute, mixed $value)
    {
        $attribute = (bool) $attribute;
        $value = (array) $value;
        $value = array_filter($value, fn($item) => !empty($item));
        if (empty($value)) return;
        $this->container[] = ['value' => implode(', ' ,$value), 'isbold' => $attribute];
    }

    public function key(): string
    {
        return 'main_info';
    }
}
