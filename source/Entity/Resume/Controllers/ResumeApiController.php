<?php

namespace Source\Entity\Resume\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Source\Entity\Resume\Models\Workplace;
use Source\Lib\Api\UserAccessToken;
use Source\Lib\AppLib;
use Symfony\Component\HttpFoundation\Response;

class ResumeApiController extends \Source\Lib\Api\ApiController
{
    public function workplaceDelete(Request $request, UserAccessToken $accessToken): JsonResponse
    {
        $id = $this->requiredParam('id');
        $token = $request->cookie(AppLib::USER_TOKEN_NAME);

        if ($workplace = Workplace::find($id)) {
            if ($accessToken->canAccess($token, (int)$workplace->resume->user_id)) {
                $workplace->delete();
                return $this->response(true);
            } else {
                return $this->response(false, Response::HTTP_FORBIDDEN, 'Bad token');
            }
        }

        return $this->response(false, Response::HTTP_FORBIDDEN, 'Wrong user');
    }
}
