<?php

namespace Source\Auth\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Source\Auth\Events\UserCreated;
use Source\Auth\Events\UserCreateFailed;
use Source\Auth\Requests\SignupPostRequest;
use Source\Entity\User\Models\User;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\Enums\Crud;
use Source\Helper\FormObjectTransfer\DataDefinition;
use Illuminate\Auth\Events\Registered;
use Source\Lib\Api\UserAccessToken;
use Source\Lib\AppLib;

class SignupController extends \App\Http\Controllers\Controller
{
    /**
     * Регистрация пользователя
     *
     * @param SignupPostRequest $request
     * @return RedirectResponse
     *
     */
    public function store(SignupPostRequest $request, UserAccessToken $accessToken): RedirectResponse
    {
        $validated = $request->validated();
        if ($user = (new User($validated))->createUser()) {
            // аутентификаця пользователя
            Auth::login($user);
            $other = $user->toArray();
            $other['user_browser'] = $request->userAgent();
            $other['prev_page'] = $_SERVER['HTTP_REFERER'] ?? '-';
            // выбрасываем событие об успешном создании пользователя
            UserCreated::dispatch(Crud::CREATE, $user->id, $other, $request->ip());
            User::getCountedAuthors(true);

            event(new Registered($user));

            $request->session()->regenerate();
            $token = UserAccessToken::generateToken();
            $accessToken->save($token, $user->id);

            return redirect('/my')->cookie(AppLib::USER_TOKEN_NAME, $token);
        };
        // выбрасываем событие о неуспешном создании пользователя
        UserCreateFailed::dispatch(Crud::CREATE, $request->input(), $request->ip());
        return back()->with('form_save_error', __('validation.form_save_error'));
    }

    public function render(): View
    {
        $form = new UserForm(new DataDefinition());
        $form->setDefaultAttributes(['policyagreed' => 1]);
        return view('pages.signup', ['formData' => $form->export('signup')]);
    }
}
