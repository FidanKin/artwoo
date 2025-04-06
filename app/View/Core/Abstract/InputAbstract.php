<?php

namespace App\View\Core\Abstract;

abstract class InputAbstract extends BaseAbstract implements \App\View\Core\Interfaces\InputInterface
{
    public string $inputSize;

    abstract protected function allowedInputSizes();

    public function getInputSize(): string
    {
        return $this->getAllowedValue($this->inputSize, $this->allowedInputSizes(),
            $this->allowedInputSizes()['normal']);
    }
}
