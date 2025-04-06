<?php

namespace Source\Auth\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Source\Auth\Events\UserAuthorizedSuccessfully;
use Source\Auth\Events\UserAuthorizedFailed;
use Source\Auth\Requests\AuthorizationPostRequest;
use Source\Entity\User\Templates\Forms;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\Enums\Crud;
use Source\Entity\User\Models\User;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Source\Lib\Api\UserAccessToken;
use Source\Lib\AppLib;

class AuthorizationController extends \App\Http\Controllers\Controller
{
    /**
     * Авторизация пользователя
     *
     * @param AuthorizationPostRequest $request
     * @return RedirectResponse
     *
     */
    public function login(AuthorizationPostRequest $request, UserAccessToken $accessToken): RedirectResponse
    {
        $validated = $request->validated();
        // не логируем пароль
        $cloneattr = User::filterUserAttributes($validated);

        if(Auth::attempt($validated)) {
            $token = UserAccessToken::generateToken();
            $accessToken->save($token, auth()->user()->id);
            $request->session()->regenerate();
            // выбрасываем событие об успешной авторизации
            UserAuthorizedSuccessfully::dispatch(Crud::READ, auth()->id(), $cloneattr, $request->ip());
            return redirect("/author/" . auth()->user()->id)->cookie(AppLib::USER_TOKEN_NAME, $token);
        }

        // выбрасываем событие об неуспешной попытке авторизации
        UserAuthorizedFailed::dispatch(Crud::READ, $cloneattr, $request->ip());
        return back()->with('form_save_error', __('auth.authorization_failed'));
    }

    public function render(): View
    {
        $formHandler = new UserForm(new DataDefinition(DataDefinition::MOD_RENDER));
        return view('pages.authorization', ['formData' => $formHandler->export('authorization')]);
    }
}
