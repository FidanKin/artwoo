<?php

namespace Source\Entity\Resume\Requests;

use Source\Entity\Resume\Models\Resume;
use Source\Entity\Resume\Templates\ResumeForm;
use Source\Entity\User\Templates\Forms;
use Source\Helper\FormObjectTransfer\DataDefinition;

class ResumeFormPost extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules(): array {
        $form = new ResumeForm(new DataDefinition(DataDefinition::MOD_CHECK));
        return $form->export('resume');
    }




}
