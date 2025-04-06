<?php

namespace Source\Entity\User\Requests;

use Source\Lib\Abstracts\SearchInputs;

final class AuthorSearchInputs extends SearchInputs
{
    protected function allowedInputNames(): array
    {
        return ['search'];
    }
}
