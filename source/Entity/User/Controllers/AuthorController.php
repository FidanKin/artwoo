<?php

namespace Source\Entity\User\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Source\Entity\Artwork\Models\Artwork;
use Source\Entity\User\Models\User;
use Source\Entity\User\Requests\ArtworkFilter;
use Source\Entity\User\Requests\AuthorSearchInputs;
use Source\Entity\User\Templates\Output;
use Source\Lib\AppLib;
use Source\Entity\Artwork\Templates\PreviewOne as ArtworkPreviewOutputOne;
use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;

class AuthorController extends \App\Http\Controllers\Controller
{
    public function author(Request $request, Navigation $navigation, $id): \Illuminate\Contracts\View\View
    {
        /** @var User $author*/
        $author = User::find($id);

        if (empty($author)) {
            abort(404);
        }

        $isUserSelf = AppLib::isUserSelf($author['id']);

        $artworksToExport = [];
        $additional = [];
        $additional['creativity_name'] = $author->getCreativityLangString();
        $additional['age'] = '';
        if ($author->birthday) {
            $additional['age'] = $author->getAge();
        }
        $additional['avatar_icon'] = $author->getIconUrl();
        $additional['socials'] = $author->getSocialsLink();
        $additional['resume_link'] = !empty($author->resume) || $id === auth()->user()?->id;
        $authorArray = array_merge($author->toArray(), $additional);

        $artworks = $author->artworks()->orderBy('created_at', 'DESC')->filter($request->query() ?? [])->get();

        foreach ($artworks as $artwork) {
            $item = $artwork->toArray();
            $images = $artwork->getImageUrls();
            if (empty($images)) {
                // нет изображений, пользователь попытался загрузить недопустимое изображение или что - то пошло не так :(
                // поэтому пропускаем, пока не знаю, как это поправить
                // @todo - поправить !!!
                continue;
            }
            $item['image'] = $images[0];
            $item['category'] = Artwork::artwork_types_list()[$item['category']];
            $artworksToExport[] = $item;
        }

        $navString = __('user.navigation.author', ['name' => $author->login]);
        $navPath = "/author/{$author->id}";

        if ($isUserSelf) {
            $navString = __('user.navigation.my_page');
            $navPath = '/my';
        }

        $navigation->add(new NavigationItemDTO($navPath, $navString, true));

        $data = [
            'author' => $authorArray,
            'artworks' => $artworksToExport,
            'can_contact' => !$isUserSelf,
            'actions' => [
                'edit' => url("/artwork/edit/{$id}"),
                'delete' => url("/artwork/delete/{$id}"),
            ],
            'user_navigation' => $this->createAuthorNavigation($author['id']),
            'navigation' => $navigation->build(),
            'can_send_message' => canSendMessage($authorArray['id'])
        ];

        return view('pages/author-main', $data);
    }

    public function authors(Request $request, Navigation $navigation): \Illuminate\Contracts\View\View
    {
        $authorsData = [];
        $searches = new AuthorSearchInputs($request);
        $authorPaginator = User::getAuthorsWithPagination($searches);

        foreach ($authorPaginator as $author) {
            $userArtworks = Artwork::getArtworksByQuantityFromUser($author->id, 3);

            if (empty($userArtworks)) {
                // автор еще не загружал работы :(
                $authorsData[$author->id]['artwork']['empty'] = [];
            }

            foreach ($userArtworks as $userArtwork) {
                $preview = new ArtworkPreviewOutputOne($userArtwork['artwork'], $userArtwork['images_url']);
                $authorsData[$author->id]['artwork'][$userArtwork['artwork']->id] = $preview->getContext();
            }

            $userOutput = new Output($author);
            $authorsData[$author->id]['author'] = $userOutput->authorContext();
        }

        $navigation->add(new NavigationItemDTO('/author', __('user.navigation.authors'), true));

        return view('pages/authors', [
            'authors' => $authorsData,
            'paginator' => $authorPaginator,
            'quantity' => User::getCountedAuthors(),
            'searches' => $searches(),
            'navigation' => $navigation->build()
        ]);
    }

    /**
     * Удаление аккаунта
     *
     * @return RedirectResponse
     */
    public function accountDelete(User $user, Request $request, int $id): RedirectResponse {
        $isAdmin = AppLib::isAdmin($user);

        if ($user->id !== $id) {
            if (! $isAdmin) {
                abort(403);
            }
        }

        // выполняем мягкое удаление
        $user->delete();

        if ($isAdmin) {
            return redirect()->back();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Сформировать навигацию по категориям работ пользователя
     */
    private function createAuthorNavigation(int $authorId): array
    {
        $currentpath = \request()->path();
        // добавляем параметр стоимости работы, чтобы отсеить работы в наличии
        $params = \http_build_query(['price_from' => 1]);
        $haspriceurl = $currentpath . '?' . $params;

        $filters[] = $this->authorNavigationLink($currentpath, 'artwork.filter.all');
        $filters[] = $this->authorNavigationLink($haspriceurl, 'artwork.filter.in_stock');
        return $filters;
    }

    /**
     * Получаем массив для формирования url в навигации пользователя
     *
     * @param string $path - путь запроса с get параметрами
     * @param string $langString - языковая строка ссылки
     * @return array
     */
    private function authorNavigationLink(string $path, string $langString): array
    {
        $currentRequestParams = \request()->input();
        $active = false;

        $parsedUrl = \parse_url($path, PHP_URL_QUERY);

        if (empty($parsedUrl) && empty($currentRequestParams)) {
            $active = true;
        } else if (!empty($currentRequestParams)) {
            \parse_str($path, $result);
            if (isset($currentRequestParams['price_from']) && \str_contains($parsedUrl, 'price_from') !== false) {
                $active = true;
            }
        }

        return ['url' => "/{$path}", 'text' => __($langString), 'weight' => 'bold', 'active' => $active];
    }
}
