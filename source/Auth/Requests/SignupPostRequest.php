<?php

namespace Source\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\FormObjectTransfer\DataDefinition;

class SignupPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $form = new UserForm(new DataDefinition( DataDefinition::MOD_CHECK));
        return $form->export('signup');
    }
}
