<?php

namespace Source\Entity\Resume\Templates;

use Source\Entity\Resume\Dictionaries\PreferredWork;
use Source\Helper\Enums\FormElementsFormat;

class ResumeForm extends \Source\Helper\FormObjectTransfer\FormInstance
{
    /**
     * Основная форма резюме
     *
     * @return void
     */
    public function form_resume(): void {
        $this->definition->add('skills', __('resume.skills'),
            [],FormElementsFormat::AUTOCOMPLETE, 'required|string');
        $this->definition->add('preferred_work', __('resume.preferred_work'),
            ['select' => PreferredWork::getSelectList()],FormElementsFormat::SELECT, 'required|string');
        $this->definition->add('has_art_education',  __('resume.has_art_education'), [],
            FormElementsFormat::CHECKBOX, 'string|nullable');
        $this->definition->add('has_pedagogical_education', __('resume.has_pedagogical_education'), [],
            FormElementsFormat::CHECKBOX, 'string|nullable');
    }

    /**
     * Форма добавления места работы
     *
     * @return void
     */
    public function form_add_workplace(): void {
        $dateFormat = config('app.artwoo.date.validation_format');

        $this->definition->add('organization_name', __('resume.organization_name'),
            [],FormElementsFormat::TEXT, 'required|string');
        $this->definition->add('position', __('resume.position'), [],
            FormElementsFormat::TEXT, 'required|string|max:120');
        $this->definition->add('duties', __('resume.duties'), [], FormElementsFormat::TEXT,
            'required|min:10|string');
        $this->definition->add('date_employment', __('resume.date_employment'), ['default_date' => '01.01.2023'],
            FormElementsFormat::DATE,"{$dateFormat}|required");
        $this->definition->add('date_dismissal', __('resume.date_dismissal'), ['default_date' => '01.01.2024'],
            FormElementsFormat::DATE,"{$dateFormat}|required");
        $this->definition->add('description', __('resume.description'), [], FormElementsFormat::TEXT,
            'required|string');
    }

    /**
     * @inheritDoc
     */
    protected function validation(array &$data): void
    {
        // TODO: Implement validation() method.
    }
}
