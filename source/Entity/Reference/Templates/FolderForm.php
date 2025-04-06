<?php

namespace Source\Entity\Reference\Templates;

use Source\Helper\Enums\FormElementsFormat;

class FolderForm extends \Source\Helper\FormObjectTransfer\FormInstance
{
    /**
     * {@inheritDoc}
     */
    protected function validation(array &$data): void
    {

    }

    protected function form_add_folder(): void
    {
        $this->definition->add('name', __('reference.folder_name'), [], FormElementsFormat::TEXT, 'required|min:5|max:100|string');
        $this->definition->add('description', __('reference.folder_description'), [], FormElementsFormat::TEXT, 'string|nullable');
        $this->definition->add('automatic_deletion', __('reference.automatic_deletion'), [],
            FormElementsFormat::CHECKBOX, 'string|nullable');
    }
}
