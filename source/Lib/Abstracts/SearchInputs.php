<?php

namespace Source\Lib\Abstracts;

use Illuminate\Http\Request;

abstract class SearchInputs
{
    final public function __construct(protected Request $request)
    {

    }

    abstract protected function allowedInputNames(): array;

    final public function __invoke(): array
    {
        return $this->request->only($this->allowedInputNames());
    }
}
