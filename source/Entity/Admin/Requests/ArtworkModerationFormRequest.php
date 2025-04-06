<?php

namespace Source\Entity\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtworkModerationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['status' => 'required|string', 'comment' => 'required|string|min:2', 'target_user' => 'required|int', 'component' => 'required|string',
            'moderator' => 'required|int', 'object_id' => 'required|int', 'other' => 'required|array'];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['component' => 'artwork', 'moderator' => $this->user()->id, 'other' => ['status' => $this->status]]);
    }
}
