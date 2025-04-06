<?php

namespace Source\Entity\Main\Requests;

use Source\Lib\Abstracts\SearchInputs;

class MainSearchInputs extends SearchInputs
{
    protected function allowedInputNames(): array
    {
        return ['search', 'price_from', 'price_to', 'price_no', 'topic', 'color', 'width_from', 'width_to',
            'height_from', 'height_to', 'depth_from', 'depth_to', 'component_number'];
    }
}
