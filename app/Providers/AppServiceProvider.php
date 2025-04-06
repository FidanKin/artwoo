<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Source\Entity\Artwork\Models\Artwork;
use Source\Entity\Resume\Models\Resume;
use Source\Entity\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // биндим нащ класс для работы с пользователем
        $this->app->bind(User::class, function() {
            $user = Auth::user();
            return $user instanceof User ? $user : new $user();
        });

        $this->app->singleton(Navigation::class, function (Application $app) {
            return new \Source\Lib\Navigation([new NavigationItemDTO('/', __('core.main'), false)]);
        });

        $this->app->singleton(Resume::class, function () {
            try {
                $resumeInstance = Resume::whereBelongsTo($this->app->get(User::class))->get();
                if (!$resumeInstance->isEmpty()) {
                    return $resumeInstance->first();
                }
            } catch (\Exception $exception) {

            }
            return null;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share("primaryColor", "#2666e0");
        View::share('invalidInputColorBg', 'bg-inputInvalid');
        View::share('invalidInputColorText', 'text-invalid-value');
        View::share('artworkColors', array_filter(Artwork::getColorsMenu(), fn($key) => $key !== 'none', ARRAY_FILTER_USE_KEY));
        Schema::defaultStringLength(191);
        // добавим строгий режим для работы с моделями
        Model::shouldBeStrict(! $this->app->isProduction());

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\'.class_basename($modelName).'Factory';
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage())
                ->subject(__('mail.reset_password.subject'))
                ->line(__('mail.reset_password.reason'))
                ->action(__('mail.reset_password.action'), $url)
                ->line(__('mail.reset_password.action_text', ['count' => config('auth.passwords.' .
                    config('auth.defaults.passwords').'.expire')]))
                ->line(__('mail.reset_password.wrong_mail'));
        });
    }
}
