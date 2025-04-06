<?php

namespace Source\Lib\FormState;

use Illuminate\Http\RedirectResponse;

/**
 * Записываем в сессию сообщение об успехе и редиректим
 */
function artwooSessionFormSaved(string $to, string $message = null): RedirectResponse
{
    if (empty($message)) {
        $message = __('core.form.form_saved');
    }

    return redirect($to)->with('form_result', ['state' => 'success', 'message' => $message]);
}

/**
 * Не удалось сохранить форму
 */
function artwooSessionFormFailed(string $message = null): RedirectResponse
{
    if (empty($message)) {
        $message = __('core.form.form_failed');
    }

    return redirect()->back()->with('form_result', ['state' => 'failed', 'message' => $message]);
}

/**
 * Ошибка, нарушение логики, неверные данные
 */
function artwooSessionFormError(string $to, string $message): RedirectResponse
{
    return redirect($to)->with('form_result', ['state' => 'error', 'message' => $message]);
}

/**
 * Получить цвет для отображения сообщения в зависимости от состояния формы
 *
 * @todo https://tailwindui.com/components/application-ui/feedback/alerts
 */
function artwooSessionResolveState(): array
{
    if (session()->has('form_result')) {
        return [
            'template_name' => 'shared.notification.simple.'.
              session()->get('form_result')['state'],
            'message' => session()->get('form_result')['message'],
        ];
    }

    return [];
}
