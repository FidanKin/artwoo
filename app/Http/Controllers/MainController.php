<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Source\Entity\Artwork\Models\Artwork;
use Source\Entity\Main\Requests\MainGetFormRequest;
use Source\Entity\Main\Requests\MainSearchInputs;

class MainController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $searches = new MainSearchInputs($request);
        $artworks = Artwork::getAllWithPagination(true, $searches);
        $tags = Artwork::tags($request->query() ?? []);

        return view('pages.main', [
            'items' => $artworks->mutationEntity,
            'pagination' => $artworks->model,
            'tags' => $tags,
            'searches' => $searches(),
        ]);
    }
}
