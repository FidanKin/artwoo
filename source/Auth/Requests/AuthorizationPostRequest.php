<?php

namespace Source\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\FormObjectTransfer\DataDefinition;

class AuthorizationPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return (new UserForm(new DataDefinition( DataDefinition::MOD_CHECK)))->export('authorization');
    }
}
