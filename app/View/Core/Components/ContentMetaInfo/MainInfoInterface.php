<?php

namespace App\View\Core\Components\ContentMetaInfo;

interface MainInfoInterface
{
    public function getValueForRender();

    public function add(mixed $attribute, mixed $value);

    public function key(): string;
}
