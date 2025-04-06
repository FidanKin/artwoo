<?php

namespace Source\Entity\Resume\Controllers;

require_once(base_path() . "/source/Lib/FormState.php");

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Source\Entity\Resume\Models\Workplace;
use Source\Entity\Resume\Requests\ResumeFormPost;
use Source\Entity\Resume\Requests\ResumeWorkplaceFormPost;
use Source\Entity\Resume\Templates\ResumeForm;
use Source\Entity\Resume\Templates\WorkplaceOutput;
use Source\Entity\User\Models\User;
use Source\Entity\Resume\Models\Resume;
use Source\Entity\User\Templates\Output;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Source\Lib\AppLib;
use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;
use function Source\Lib\FormState\artwooSessionResolveState;
use function Source\Helper\Datetimelib\{artwooDiffTwoTimestamps, artwooSumIntervalToHumanFormat};

class ResumeController extends Controller
{
    public function getEditPage(Navigation $navigation, ?Resume $resume): View
    {
        $formAttributes = $resume ? $resume->toArray() : [];
        $workplaces = [];
        $navigation->addMyNode();

        if ($resume) {
            $workplacesCollection = $resume->workplace;
            $workplaces = $workplacesCollection->map(function($workplace, $index) {
                return WorkplaceOutput::getContext($workplace);
            });
            $navigation->add(new NavigationItemDTO("/resume/{$resume->user_id}", __('resume.view_resume')));
        }

        $form = new ResumeForm(new DataDefinition());
        $form->setDefaultAttributes($formAttributes);
        $resumeForm = $form->export('resume');
        $workplaceForm = $form->export('add_workplace');
        $formData = array_merge($resumeForm, $workplaceForm);
        $showWorkplaceButton = $resume ?? false; // не отображаем кнопку добавления места работы, если резюме нет

        $navigation->add(new NavigationItemDTO('/resume/edit', __('resume.navigation.edit'), true));

        return view('pages/resume-edit', [
            'formData' => $formData,
            'formState' => artwooSessionResolveState(),
            'showWorkplaceButton' => $showWorkplaceButton,
            'workplaces' => $workplaces,
            'navigation' => $navigation->build(),
        ]);
    }

    /**
     * Добавляем рабочее место к резюме
     *
     * @param ResumeWorkplaceFormPost $request
     * @param Resume|null $resume
     * @return RedirectResponse
     */
    public function workplaceSave(ResumeWorkplaceFormPost $request, ?Resume $resume): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data)) {
            // у данного пользователя еще нет резюме
            return \Source\Lib\FormState\artwooSessionFormError("/resume/edit", __('resume.instance_not_exist'));
        }
        $workplace = new Workplace();
        $workplace->resume_id = $resume->id;
        $workplace->organization_name = $data['organization_name'];
        $workplace->position = $data['position'];
        $workplace->duties = $data['duties'];
        $workplace->date_employment = $data['date_employment'];
        $workplace->date_dismissal = $data['date_dismissal'];
        $workplace->description = $data['description'];
        if ($workplace->save()) {
            return \Source\Lib\FormState\artwooSessionFormSaved("/resume/edit");
        }

        return \Source\Lib\FormState\artwooSessionFormFailed(__('resume.cannot_save'));
    }

    /**
     * Сохраняем резюме
     *
     * @param ResumeFormPost $request
     * @param User $user
     * @param ?Resume $resume
     * @return RedirectResponse
     */
    public function resumeSave(ResumeFormPost $request, User $user, ?Resume $resume): RedirectResponse
    {
        $data = $request->validated();
        $resume = !empty($resume) ? $resume : new Resume();
        $resume->user_id = $user->id;
        $resume->skills = $data['skills'];
        $resume->preferred_work = $data['preferred_work'];
        $resume->has_art_education = $request->has('has_art_education');
        $resume->has_pedagogical_education = $request->has('has_pedagogical_education');

        if ($resume->save()) {
            return \Source\Lib\FormState\artwooSessionFormSaved("/resume/edit");
        }

        return \Source\Lib\FormState\artwooSessionFormFailed('resume.cannot_save');
    }

    /**
     * Отображение резюме пользователю
     *
     * @param ?int $id - идентификатор пользователя резюме
     */
    public function index(User $user, Navigation $navigation, int $id = null): \Illuminate\Contracts\View\View|RedirectResponse
    {
        if (is_null($id)) {
            $resume = $user->resume;
        } else {
            $resume = Resume::where('user_id', '=', $id)->first();
        }

        // резюме нет (не создано)
        if (empty($resume)) {
            if ($user->id === $id) {
                // текущий пользователь пытаемся перейти к своему резюме, переведем его на страницу редактирования резюме
                return redirect('/resume/edit');
            }

            // редирект обратно на страницу пользователя, т.к. резюме нет
            return redirect()->back();
        }

        $context = new Output($resume->user);

        $workplaces = $resume->workplace->map(fn($workplace) =>WorkplaceOutput::getContext($workplace))->all();

        $navigation
            ->add(new NavigationItemDTO("/author/{$resume->user_id}", __('user.navigation.author',
                ['name' => $resume->user->login])))
            ->add(new NavigationItemDTO("/resume/{$resume->user_id}", __('resume.view_resume'), true));

        return view('pages/resume', [
          'author' => $context->authorContext(),
          'metaInfo' => $resume->getMetaInfo(),
          'skills' => $resume->getSkillsValues(),
          'workplaces' => $workplaces,
          'title' => __('resume.view_title'),
          'actions' => [
              'edit' => '/resume/edit/',
          ],
          'can_edit' => AppLib::canEditBase($resume->user),
            'navigation' => $navigation->build(),
        ]);
    }
}
