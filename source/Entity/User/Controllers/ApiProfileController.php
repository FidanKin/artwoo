<?php

namespace Source\Entity\User\Controllers;

use app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Source\Entity\User\Models\User;
use Source\Lib\Api\ApiController;
use Source\Lib\Api\UserAccessToken;
use Source\Lib\AppLib;
use Source\Lib\FileStorage;
use Symfony\Component\HttpFoundation\Response;

class ApiProfileController extends ApiController
{
    public function deleteUserPicture(Request $request, UserAccessToken $accessToken): \Illuminate\Http\JsonResponse
    {
        $cookieToken = $request->cookie(AppLib::USER_TOKEN_NAME);
        $pathnamehash = $this->requiredParam('pathhash');
        $fromUserId = (int) $this->requiredParam('source_id');

        if (User::find($fromUserId) && $accessToken->canAccess($cookieToken, $fromUserId)) {
            if (FileStorage::deleteByPathnamehash($pathnamehash)) {
                return $this->response(true);
            }
        }

        return $this->response(false, Response::HTTP_FORBIDDEN, 'Wrong user');
    }
}
