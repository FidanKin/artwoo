<?php

namespace Source\Auth\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Source\Auth\Requests\SignupPostRequest;
use Source\Entity\User\Models\User;
use Source\Entity\User\Templates\UserForm;
use Source\Helper\FormObjectTransfer\DataDefinition;

class ResetPasswordController extends \app\Http\Controllers\Controller
{
    /**
     * Обработка сброса пароля
     *
     * @param SignupPostRequest $request
     * @return RedirectResponse
     *
     */
    public function reset(Request $request): RedirectResponse {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['status' => __($status)]);
    }

    public function resetRender(Request $request, string $token): View {
        $form = new UserForm(new DataDefinition());

        if ($mail = $request->query('email')) {
            $form->setDefaultAttributes(['email' => $mail]);
        }

        return view('pages.auth.reset-password', [
            'formData' => $form->export('reset_password'),
            'token' => $token
        ]);
    }
}
