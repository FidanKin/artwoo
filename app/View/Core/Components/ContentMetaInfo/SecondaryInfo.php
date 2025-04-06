<?php

namespace App\View\Core\Components\ContentMetaInfo;

class SecondaryInfo implements MainInfoInterface
{
    private array $container = [];

    private array $allowedTypes = ['text', 'icon'];
    public function getValueForRender()
    {
        return $this->container;
    }

    public function add(mixed $attribute, mixed $value)
    {
        $attribute = (string) $attribute;
        $value = (string) $value;
        if (!in_array($attribute, $this->allowedTypes)) {
            throw new \InvalidArgumentException('Key must be: ' .
                implode(',', $this->allowedTypes));
        }
        if (empty($value)) return;
        $this->container[] = ['value' => $value, 'type' => $attribute];
    }

    public function key(): string
    {
        return 'secondary_info';
    }
}
