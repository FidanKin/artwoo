<?php

namespace Source\Entity\Reference\Requests;

use Source\Entity\Reference\Templates\FolderForm;

class FolderCreatePostRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $folderForm = new FolderForm(new \Source\Helper\FormObjectTransfer\DataDefinition(
            \Source\Helper\FormObjectTransfer\DataDefinition::MOD_CHECK
        ));

        return $folderForm->export('add_folder');
    }
}
