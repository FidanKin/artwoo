<?php

namespace Source\Entity\Reference\Requests;

use Source\Lib\Abstracts\SearchInputs;

class ReferenceSearchInputs extends SearchInputs
{
    protected function allowedInputNames(): array
    {
        return ['search', 'folder_id'];
    }
}
