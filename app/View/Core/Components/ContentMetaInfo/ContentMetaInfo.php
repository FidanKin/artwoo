<?php

namespace App\View\Core\Components\ContentMetaInfo;

final class ContentMetaInfo implements \ArrayAccess
{
    private array $meta;

    public function offsetExists(mixed $offset): bool
    {
        if (!($offset instanceof MainInfoInterface)) {
            throw new \InvalidArgumentException('Value must be implemented ' . MainInfoInterface::class);
        }

        return isset($this->meta[$offset->key()]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (is_null($offset)) return $this->meta;

        if (!($offset instanceof MainInfoInterface)) {
            throw new \InvalidArgumentException('Value must be implemented ' . MainInfoInterface::class);
        }

        return $this->meta[$offset->key()];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!($value instanceof MainInfoInterface)) {
            throw new \InvalidArgumentException('Value must be implemented ' . MainInfoInterface::class);
        }

        $this->meta[$value->key()] = $value->getValueForRender();
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!($offset instanceof MainInfoInterface)) {
            throw new \InvalidArgumentException('Value must be implemented ' . MainInfoInterface::class);
        }

        unset($this->meta[$offset->key()]);
    }
}
