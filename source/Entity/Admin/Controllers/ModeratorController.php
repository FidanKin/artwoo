<?php

namespace Source\Entity\Admin\Controllers;

use app\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Source\Entity\Admin\Models\Moderation;
use Source\Entity\Admin\Requests\ArtworkModerationFormRequest;
use Source\Entity\Admin\Requests\UserModerationFormPostRequest;
use Source\Entity\Artwork\Dictionaries\ArtworkStatus;
use Source\Entity\User\Dictionaries\UserStatus;
use Source\Entity\User\Models\User;
use Source\Entity\Artwork\Models\Artwork;

class ModeratorController extends Controller
{
    /**
     * Вью модерации пользователя
     *
     * @return View
     */
    public function usersModeration(): View
    {
        $drafts = User::getDraftUsers();
        return view('pages.admin.users-moderation', ['users' => $drafts, 'select' => UserStatus::select()]);
    }

    /**
     * Действие модерации над пользователем
     *
     * @param UserModerationFormPostRequest $request
     * @return RedirectResponse
     */
    public function usersModerationAction(UserModerationFormPostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['status']);
        $model = new Moderation($data);

        if ($model->save()) {
            return redirect()->back()->with('success', sprintf('User with id = "%d" was moderated', $data['object_id']));
        }

        return redirect()->back()->withErrors(['saved_error' => sprintf('Cannot change status for user with id = "%d"', $data['object_id'])]);
    }

    /**
     * Отобразить творческие работы для модерации
     *
     * @return View
     */
    public function artworksModeration(): View
    {
        $artworks = Artwork::getDrafts();
        return view('pages.admin.artworks-moderation', ['paginator' => $artworks->model, 'artworks' => $artworks->mutationEntity,
            'select' => ArtworkStatus::select()]);
    }

    /**
     * Действие модерации творческой работы
     *
     * @param ArtworkModerationFormRequest $request
     * @return RedirectResponse
     */
    public function artworksModerationAction(ArtworkModerationFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['status']);
        /** @var Artwork $artwork */
        $artwork = Artwork::find($data['object_id']);
        $data['other']['name'] = $artwork->name;
        $data['other']['description'] = $artwork->description;
        $data['other']['images'] = $artwork->getImageUrls();
        $model = new Moderation($data);

        if ($model->save()) {
            return redirect()->back()->with('success', sprintf('Artwork with id = "%d" was moderated', $data['object_id']));
        }

        return redirect()->back()->withErrors(['saved_error' => sprintf('Cannot change status for artwork with id = "%d"', $data['object_id'])]);
    }
}
