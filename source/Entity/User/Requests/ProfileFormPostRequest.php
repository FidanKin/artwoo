<?php

namespace Source\Entity\User\Requests;

use Source\Entity\User\Templates\Forms;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\FormObjectTransfer\DataDefinition;

class ProfileFormPostRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules(): array {
        $form = new UserForm(new DataDefinition(DataDefinition::MOD_CHECK));
        return $form->export('profile');
    }
}
