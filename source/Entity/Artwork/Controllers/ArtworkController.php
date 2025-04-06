<?php

namespace Source\Entity\Artwork\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Source\Entity\Artwork\Events\ArtworkCreatedFail;
use Source\Entity\Artwork\Events\ArtworkCreatedSuccessfully;
use Source\Entity\Artwork\Models\Artwork;
use Source\Entity\Artwork\Requests\ArtworkFormPostRequest;
use Source\Entity\Artwork\Templates\ArtworkForm;
use Source\Entity\User\Models\User;
use Source\Helper\Enums\Crud;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Source\Lib\AppLib;
use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;
use function Source\Lib\FormState\{artwooSessionResolveState, artwooSessionFormSaved};

class ArtworkController extends Controller
{
    /**
     * @param User $user
     * @param $id
     */
    public function getEditRender(User $user, Navigation $navigation, $id = null): View
    {
        $artworkModel = null;
        $form = new ArtworkForm(new DataDefinition());
        $navigation->add(new NavigationItemDTO('/my', __('user.navigation.my_page')));
        if ($id) {
            if ($artworkModel = Artwork::find($id)) {
                $author = $artworkModel->user;
                if (! AppLib::canEditBase($author)) {
                    abort(403);
                }
                $artwork = $artworkModel->toArray();
                $artwork['has_components'] = count($artwork['size']) > 1 ? 1 : 0;
                $fs = new FileStorage();
                $form->addFilesDefinitions('images', $fs->getFilesAsUrl(new FileIdentityDTO('artwork',
                    $user->id, $id)));
                $form->setDefaultAttributes($artwork);
                $size = $artwork['size'];
                $navigation->add(new NavigationItemDTO("/artwork/edit/{$id}", __('artwork.navigation.edit'),
                    true));
            } else {
                abort(404);
            }
        } else {
            $navigation->add(new NavigationItemDTO('/artwork/edit', __('artwork.navigation.edit'), true));
        }

        $size = ArtworkForm::sizeToForm($artworkModel);

        $formData = $form->export('artwork');
        $formData['actions'] = [
            'delete' => url("artwork/delete/{$id}"),
        ];
        $formData['hidden'] = [
            'item_id' => $id,
            'formkey' => AppLib::generate_token(400, 'artwork', $id),
        ];
        $formData['size'] = $size;

        return view('pages/artwork-edit', ['formData' => $formData, 'navigation' => $navigation->build()]);
    }

    /**
     * Изменение / добавление работы
     *
     * @param ArtworkFormPostRequest $request
     * @param User $user
     * @param $id
     * @return RedirectResponse
     */
    public function save(ArtworkFormPostRequest $request, User $user, $id = null): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $user->id;

        if (empty($id)) {
            $model = new Artwork(filterModelAttributes(new Artwork(), $data));
            $errors = $model->store($data);
            $model = $model->refresh();
            $id = $model->id;
        } else {
            /** @var Artwork $model */
            $model = Artwork::find($id);
            $errors = $model->edit($data);
        }
        $successTo = "/artwork/{$id}";

        if (! empty($request->input('go_sort'))) {
            $successTo = "/artwork/sort/{$id}";
        }

        if (empty($errors)) {
            ArtworkCreatedSuccessfully::dispatch(Crud::CREATE, $id, $user->id, [], $request->ip());
            return redirect($successTo);
        }

        if (! empty($errors['model'])) {
            ArtworkCreatedFail::dispatch(Crud::CREATE, $user->id, ['error' => $errors['model']], $request->ip());
            return redirect("/artwork/edit/{$id}")->with('form_save_result', __('core.cannot_save'));
        }

        ArtworkCreatedFail::dispatch(Crud::CREATE, $user->id, ['error' => $errors], $request->ip());
        return redirect("/artwork/edit/{$id}")->withErrors($errors);
    }

    /**
     * Интерфейс указания порядка отображения изображений
     *
     * @param $id
     * @param User $user
     * @param Navigation $navigation
     * @return View
     */
    public function getSortingPage(Navigation $navigation, User $user, $id = null): View
    {
        $fs = new FileStorage();
        $paths = $fs->getFilesAsUrl(new \Source\Lib\FileIdentityDTO('artwork', $user->id, $id));
        $artwork = Artwork::find($id);

        if (! $artwork || $artwork->user_id !== $user->id) {
            abort(403);
        }

        $navigation
            ->add(new NavigationItemDTO("/author/{$user->id}", __('user.navigation.author', [
                'name' => $user->login])))
            ->add(new NavigationItemDTO("/artwork/{$id}", __('artwork.navigation.artwork', [
                'name' => $artwork->name])))
            ->add(new NavigationItemDTO("/artwork/sort/{$id}", __('artwork.navigation.edit_sort'), true));

        return view('pages/artwork-sort', ['artworkImages' => $paths, 'navigation' => $navigation->build(),
            'artworkId' => $id]);
    }

    /**
     * Обработка обновления сортировки
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function saveSorting(Request $request, $id): RedirectResponse
    {
        /** @var Artwork $artwork */
        $artwork = Artwork::find($id);

        if (! $artwork) {
            abort(404);
        }

        $author = User::find($artwork->user_id);

        if (! $author || ! AppLib::canEditBase($author)) {
            abort(403);
        }

        $sorting = json_decode($request->input('sorting'));
        $value = Arr::map($sorting, function ($item) {
            $item = (array)$item;
            return [array_key_first($item), array_pop($item)];
        });

        $message = __('artwork.messages.sorting_success_saved');

        if (! $artwork->updateImagesOrder($value)) {
            $message = __('artwork.messages.sorting_not_saved');
        }

        return artwooSessionFormSaved("/artwork/{$id}", $message);
    }

    public function getAuthorView(Navigation $navigation, $id): \Illuminate\Contracts\View\View
    {
        /** @var Artwork $artwork */
        $artwork = Artwork::find($id);

        if (empty($artwork)) {
            abort(404);
        }

        // у работы всегда есть автор, поэтому не делаем проверок
        /** @var User $artworkUserModel */
        $artworkUserModel = $artwork->user;

        $artworkUser = array_merge($artworkUserModel->toArray(), $artworkUserModel->customFields());
        $artworkUser['creativity_name'] = $artworkUserModel->getCreativityLangString();
        $artworkUser['age'] = $artworkUserModel->getAge();
        $artworkUser['avatar_icon'] = $artworkUserModel->getIconUrl();
        $artworkUser['socials'] = $artworkUserModel->getSocialsLink();

        $fs = new FileStorage();

        $artworkArray = $artwork->unsetRelation('user')->toArray();
        $artworkArray['image_paths'] = $fs->getFilesAsUrl(new \Source\Lib\FileIdentityDTO('artwork', $artworkUser['id'], $artwork->id));
        $artworkArray['topic'] = Artwork::artwork_topics_list()[$artwork->topic];

        $navigation
            ->add(new NavigationItemDTO("/author/{$artworkUserModel->id}", __('user.navigation.author', [
                'name' => $artworkUserModel->login])))
            ->add(new NavigationItemDTO("/artwork/{$artwork->id}", __('artwork.navigation.artwork', [
                'name' => $artwork->name]), true)
            );

        $data = [
            'author' => $artworkUser,
            'artwork' => $artworkArray,
            'can_send_message' => canSendMessage($artworkUserModel->id),
            'meta_info' => $artwork->getContentMetaInfo(),
            'formState' => artwooSessionResolveState(),
            'actions' => [
                'edit' => url("artwork/edit/{$id}"),
                'delete' => url("artwork/delete/{$id}"),
            ],
            'can_edit' => AppLib::canEditBase($artworkUserModel),
            'navigation' => $navigation->build(),
        ];

        return view('pages/artwork', $data);
    }

    /**
     * Выполнить удаление творческой работы
     *
     * @param $id - идентификатор работы
     * @return RedirectResponse
     */
    public function deleteAction($id): RedirectResponse
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $artwork = Artwork::find($id);
            if (! empty($artwork)) {
                if (! AppLib::canEditBase(User::find($artwork->user_id))) {
                    abort(403);
                }
                if ($artwork->delete()) {
                    return redirect('/');
                }

                //@todo продумать, как отобразить сообщение
                return redirect()->back()->with('artwork:delete_action', __('artwork.errors.delete'));
            }
        }
        abort(404);
    }
}
