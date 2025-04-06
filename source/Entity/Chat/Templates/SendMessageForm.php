<?php

namespace Source\Entity\Chat\Templates;

use Source\Helper\Enums\FormElementsFormat;

class SendMessageForm extends \Source\Helper\FormObjectTransfer\FormInstance
{
    /**
     * {@inheritDoc}
     */
    protected function validation(array &$data): void
    {

    }

    protected function form_send_message(): void
    {
        $this->definition->add('message', __('chat.message'), [], FormElementsFormat::TEXT,
            'required|string');

    }
}
