<?php

namespace Source\Entity\Artwork\Requests;

use Source\Entity\Artwork\Templates\ArtworkForm;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Source\Lib\FormRequestTrait;

class ArtworkFormPostRequest extends \Illuminate\Foundation\Http\FormRequest
{
    use FormRequestTrait;

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $form = new ArtworkForm(new DataDefinition(DataDefinition::MOD_CHECK));
        $rules = $form->export('artwork');

        // проверяем, что файл уже загружен в файловую зону и если загружен, то убираем из валидации,
        // что он обязателен
        $this->file_validation_rule($rules, 'images', 'artwork');

        return $rules;
    }
}
