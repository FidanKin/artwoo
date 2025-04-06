<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Source\Entity\User\Dictionaries\UserStatus;
use Source\Entity\User\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Верификация почтового адреса')
                ->line('Благодарим за регистрацию!')
                ->line('Кликните по кнопке ниже для подтверждения адреса электронной почты.
                            Если вы не регистрировались на сайте https://artwoo.ru, то не отвечайте на это сообщение.')
                ->action('Подтверждение адреса электронной почты', $url);
        });

        /**
         * Проверяем удален пользователь или же заблокирован при модерации
         * Такой пользователь не должен иметь возможности создавать контент
         */
        Gate::define('content-create', function (User $user) {
            $blockedStatus = [UserStatus::BLOCKED->value, UserStatus::DELETED->value];

            return ! in_array($user->status, $blockedStatus);
        });
    }
}
