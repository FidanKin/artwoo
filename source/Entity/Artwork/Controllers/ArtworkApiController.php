<?php

namespace Source\Entity\Artwork\Controllers;

use Illuminate\Http\Request;
use Source\Entity\Artwork\Models\Artwork;
use Source\Lib\Api\ApiController;
use Source\Lib\Api\UserAccessToken;
use Source\Lib\AppLib;
use Source\Lib\FileStorage;
use Symfony\Component\HttpFoundation\Response;

class ArtworkApiController extends ApiController
{
    public function deleteArtworkImage(Request $request, UserAccessToken $accessToken): \Illuminate\Http\JsonResponse
    {
        $artworkId = $request->get('source_id');
        $pathnamehash = $this->requiredParam('pathnamehash') ?? '';

        if ($artwork = Artwork::find($artworkId)) {
            if ($accessToken->canAccess($request->cookie(AppLib::USER_TOKEN_NAME), $artwork->user_id)) {
                if (FileStorage::deleteByPathnamehash($pathnamehash)) {
                    return $this->response(true);
                };
            } else {
                return $this->response(false, Response::HTTP_FORBIDDEN, 'wrong access');
            }
        }

        return $this->response(false, \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST, 'File not found');
    }
}
