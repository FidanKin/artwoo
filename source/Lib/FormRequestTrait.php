<?php

namespace Source\Lib;

/**
 * Валидатор для файлов
 */
trait FormRequestTrait
{
    protected function file_validation_rule(array &$rules, string $key, string $component): void
    {
        if (isset($rules[$key]) && str_contains($rules[$key], 'required') && ! empty($this->item_id)) {
            $fs = new FileStorage();
            if (! empty($fs->getFiles(new FileIdentityDTO($component, $this->user()->id, $this->item_id)))) {
                $rules[$key] = 'nullable';
            }
        }
    }
}
