<?php

namespace App\View\Core\Components\ContentMetaInfo;

class TagInfo implements MainInfoInterface
{
    private array $allowedAttributes = ['url', 'text'];
    private array $container = [];

    public function getValueForRender()
    {
        return $this->container;
    }

    public function add(mixed $attribute, mixed $value)
    {
        if (!in_array($attribute, $this->allowedAttributes)) {
            throw new \InvalidArgumentException('Key must be: ' .
                implode(',', $this->allowedAttributes));
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException('Value must be string');
        }

        $this->container[$attribute] = $value;
    }

    public function key(): string
    {
        return 'tag_info';
    }
}
