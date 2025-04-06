<?php

namespace Source\Entity\Reference\Controllers;

use App\Exceptions\BaseFileHandlerException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Source\Entity\Reference\Models\Folder;
use Source\Entity\Reference\Models\Reference;
use Source\Entity\Reference\Requests\FolderCreatePostRequest;
use Source\Entity\Reference\Requests\ReferenceSearchInputs;
use Source\Entity\Reference\Requests\ReferencesUploadPostRequest;
use Source\Entity\Reference\Templates\FolderForm;
use Source\Entity\User\Models\User;
use Source\Helper\Enums\FormElementsFormat;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;

use function Source\Lib\FormState\artwooSessionFormFailed;
use function Source\Lib\FormState\artwooSessionFormSaved;
use function Source\Lib\FormState\artwooSessionResolveState;
use function Source\Lib\Text\artwooShortText;

class ReferenceController extends \App\Http\Controllers\Controller
{
    public function index(User $user, Request $request, Navigation $navigation): \Illuminate\Contracts\View\View
    {
        $folderForm = new FolderForm(new DataDefinition());
        $folderFormData = $folderForm->export('add_folder');
        $folders = $user->folder;
        $searches = new ReferenceSearchInputs($request);

        $references = Reference::getWithPaginator($user->id, $searches);

        $navigation->addMyNode()->add(new NavigationItemDTO('/reference', __('reference.navigation.all'), true));

        return view('pages.references', [
            'formData' => $folderFormData,
            'searches' => $searches(),
            'formState' => artwooSessionResolveState(),
            'folders' => $folders->toArray(),
            'references' => $references,
            'navigation' => $navigation->build(),
        ]);
    }

    public function createFolder(FolderCreatePostRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $data['time_visited'] = date('Y-m-d H:i:s');
        $data['user_id'] = $user->id;
        $data['automatic_deletion'] = $request->has('automatic_deletion');
        $folder = new Folder($data);
        $saved = $folder->saveQuietly();

        if (! $saved) {
            return artwooSessionFormFailed(__('reference.cannot_save_folder'));
        }

        return artwooSessionFormSaved('/reference', __('reference.folder_created'));
    }

    /**
     * Отобразить референсы папки
     *
     * @param User $user - пользователь
     * @param Request $request - запрос
     * @param int $id  - идентификатор папки
     *
     * @return View
     */
    public function folderShow(User $user, Request $request, Navigation $navigation, $id): View
    {
        require_once base_path('/source/Lib/Text.php');
        /** @var Folder $folder  */
        $folder = Folder::find($id);

        if (! $folder) {
            abort(404);
        }

        $navigation->addMyNode()
            ->add(new NavigationItemDTO('/reference', __('reference.navigation.all')))
            ->add(new NavigationItemDTO("/reference/folder/{$id}", __('reference.navigation.folder',
                ['name' => $folder->name]), true)
            );

        $request->merge(['folder_id' => $id]); // добавим folder_id, чтоб фильтр сработал по папке
        $searches = new ReferenceSearchInputs($request);
        $paginatorModel = Reference::getWithPaginator($user->id, $searches);
        $request->query->remove('folder_id'); // убираем folder_id, чтоб не было ссылки на сброс фильтра

        $formData = ['add-references' => [
            'name' => 'add-reference',
            'placeholder' => 'Добавить изображения',
            'value' => null,
            'options' => ['uploaded' => [], ['item' => 'required|image|max:5000']],
            'type' => FormElementsFormat::FILE,
            'required|array|max:10',
            ]
        ];

        return view('pages/reference', [
            'searches' => $searches(),
            'paginator' => $paginatorModel,
            'folder' => $folder,
            'folderCountRefs' => $folder->getFolderQuantityReferenceFromCache(),
            'formData' => $formData,
            'formState' => artwooSessionResolveState(),
            'navigation' => $navigation->build(),
        ]);
    }

    /**
     * Обработать действие загрузки файла
     */
    public function uploadReferences(ReferencesUploadPostRequest $request, User $user, $id): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $folder = Folder::find($id);
        if (! $folder) {
            abort(404);
        }

        foreach ($data['add-reference'] as $uploadFile) {
            $ref = $folder->reference()->save(new Reference(['name' => artwooShortText($uploadFile->getClientOriginalName(), 255)]));
            $fileArea = 'user_references'."_{$ref->id}";
            try {
                $fs = new FileStorage();
                try {
                    $fs->saveMany([$uploadFile], new FileIdentityDTO('reference', $user->id, $folder->id, $fileArea));
                } catch (QueryException $queryException) {
                    Log::warning('Cannot save reference file. Message - '.$queryException->getMessage());
                }
            } catch (BaseFileHandlerException $fileException) {
                return artwooSessionFormFailed($fileException->getMessage());
            }
        }

        $folder->updateFolderQuantityReferenceInCache();

        return artwooSessionFormSaved("/reference/folder/{$folder->id}");
    }

    /**
     * Удаление референса (одного изображения)
     */
    public function itemDelete(User $user, $id): \Illuminate\Http\RedirectResponse
    {
        $ref = Reference::find($id);
        if (! $ref) {
            abort(404);
        }

        $folderId = $ref->folder_id;
        $userId = $ref->folder->user_id;
        if ($userId !== $user->id) {
            abort(401);
        }
        $folder = Folder::find($folderId);
        $fs = new FileStorage();

        try {
            $ref->delete();
            try {
                $fs->delete(new FileIdentityDTO('reference', $userId, $folderId, "user_references_{$ref->id}"));
            } catch (\Exception $exception) {
                Log::warning("Cannot delete reference item from file storage. ReferenceID: {$id}, message:
                {$exception->getMessage()}");

                return artwooSessionFormFailed(__('reference.actions.item_delete_failed'));
            }
            $folder->updateFolderQuantityReferenceInCache();
            Reference::setTopReferencesToCache($user);
        } catch (QueryException $queryException) {
            Log::warning("Cannot delete reference item. ReferenceID: {$id}, message:
                {$queryException->getMessage()}");

            return artwooSessionFormFailed(__('reference.actions.item_delete_failed'));
        }

        return artwooSessionFormSaved("/reference/folder/{$folderId}", __('reference.actions.item_deleted'));
    }

    /**
     * Удаление папки и всех референсов этой папки
     * Рефернсы удаляются по каскадному наследованию, поэтому в коде у нас нет манипуляций удаления рефов
     */
    public function folderDelete(User $user, $id): \Illuminate\Http\RedirectResponse
    {
        $folder = Folder::find($id);
        if (! $folder) {
            abort(404);
        }

        $fs = new FileStorage();
        $fs->delete(new FileIdentityDTO('reference', $user->id, $id, ''));
        $folder->delete();
        // обновим кеш
        Folder::updateAllQuantityReferencesInCache($user);
        Reference::setTopReferencesToCache($user);

        return artwooSessionFormSaved('/reference', __('reference.actions.folder_deleted'));
    }
}
