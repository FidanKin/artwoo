<?php

namespace Source\Entity\User\Controllers;

require_once(base_path() . "/source/Lib/FormState.php");

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Source\Entity\User\Models\User;
use Source\Entity\User\Requests\ProfileFormPostRequest;
use Source\Entity\User\Templates\Forms;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Illuminate\Http\Request;

use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;
use function Source\Lib\FormState\artwooSessionResolveState;

class ProfileController extends \App\Http\Controllers\Controller
{
    public function getRender(Request $request, User $user): View
    {
        return app()->make(\Source\Entity\User\Controllers\AuthorController::class)->author($request,
            app()->make(Navigation::class), $user->id);
    }

    public function editProfile(User $user, Navigation $navigation): View
    {
        $form = new UserForm(new DataDefinition(DataDefinition::MOD_RENDER));
        $form->setDefaultAttributes(array_merge($user->toArray(), $user->customFields()));
        $fs = new FileStorage();
        $form->addFilesDefinitions('user_picture', $fs->getFilesAsUrl(new FileIdentityDTO('user', $user->id,
            $user->id, 'user_picture')));

        $navigation->addMyNode()
            ->add(new NavigationItemDTO('/my/edit', __('user.navigation.editing_profile'), true));

        $formData = $form->export('profile');
        $formData['hidden'] = [
            'user_id' => $user->id,
        ];

        return view('pages.my', [
            'formData' => $formData,
            'formState' => artwooSessionResolveState(),
            'actions' => [
                'delete' => url("/author/delete/{$user->id}")
            ],
            'navigation' => $navigation->build()
        ]);
    }

    /**
     * Обновление профиля пользователя
     *
     * @param ProfileFormPostRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateProfile(ProfileFormPostRequest $request, User $user): RedirectResponse {
        $data = $request->validated();
        $data['freelance'] = $request->has('freelance');
        $data['show_socials'] = $request->has('show_socials');

        if ($user->updateUser($data, true)) {
            return \Source\Lib\FormState\artwooSessionFormSaved("/my");
        }

        return \Source\Lib\FormState\artwooSessionFormFailed(__('core.cannot_save'));
    }
}
