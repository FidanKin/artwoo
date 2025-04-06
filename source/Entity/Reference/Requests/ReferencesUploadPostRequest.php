<?php

namespace Source\Entity\Reference\Requests;

class ReferencesUploadPostRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['add-reference' => 'required'];
    }
}
