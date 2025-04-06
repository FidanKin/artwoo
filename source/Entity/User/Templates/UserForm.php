<?php

namespace Source\Entity\User\Templates;

use App\View\Core\FormElementConst;
use Source\Entity\User\Models\CreativityType;
use Source\Helper\Enums\FormElementsFormat;
use Source\Helper\FormObjectTransfer\FormInstance;

/**
 * Класс для передачи данных в формы
 * Здесь собираем данные по полю пользователя и формируем по определенным правилам
 */
final class UserForm extends FormInstance
{
    private array $extra;

    /**
     * Форма авторизации
     *
     * @return void
     */
    protected function form_authorization() {
        $this->definition->add('email', __('user.email'), [],
            FormElementsFormat::TEXT, 'required|email|exists:Source\Entity\User\Models\User');
        $this->definition->add('password', __('user.create_password'), [],
            FormElementsFormat::TEXT, 'required|max:255');
    }

    /**
     * Форма личного кабинета пользователя
     *
     * @return void
     */
    protected function form_profile(): void {
        $imageUrls = ! empty($this->extra['user_picture']) ? $this->extra['user_picture'] : [];
        $dateFormat = config('app.artwoo.date.validation_format');

        $this->definition->add('login', __('user.login'), ['state' => FormElementConst::STATE_DISABLED],
            FormElementsFormat::TEXT, 'max:255|required');
        $this->definition->add('email', __('user.email'), ['state' => FormElementConst::STATE_DISABLED],
            FormElementsFormat::TEXT, 'email|required');
        $this->definition->add('birthday',  __('user.birthday_format'), [],
            FormElementsFormat::DATE, "{$dateFormat}|nullable");
        // пока отказываемся от номера телефона
        //$this->definition->add('phone', __('user.phone'), [],
        //    FormElementsFormat::TEXT, 'regex:/^\+(?:[0-9] ?){6,14}[0-9]$/|nullable');
        $this->definition->add('freelance', __('user.freelance'), [],
            FormElementsFormat::CHECKBOX, 'string|nullable');
        $this->definition->add('creativity_type', __('core.category_creativity'),
            ['select' => CreativityType::getAuthorCreativityList()], FormElementsFormat::SELECT, "string|nullable");
        $this->definition->add('user_picture', __('user.picture'), ['uploaded' => $imageUrls], FormElementsFormat::FILE,
            'nullable|image|max:2000');
        $this->definition->add('about', __('user.about_me_form'), [], FormElementsFormat::TEXT,
            'nullable|string|max:32000');
        // пока скрываем возможность указания ссылок на социальные сети, т.к. мы их не можем подтвердить
        // пока пользователи их могут указать в описании профиля

//        $this->definition->add('telegram_username', __('user.username_in', ['service' => 'Telegram']),
//            [], FormElementsFormat::TEXT, 'string|not_regex:/[^@a-z0-9]/i|nullable');
//        $this->definition->add('vk_username', __('user.username_in', ['service' => 'VK']),
//                [], FormElementsFormat::TEXT, 'string|not_regex:/[^@a-z0-9]/i|nullable');
//        $this->definition->add('show_socials', __('user.allow_show_socials'), [],
//            FormElementsFormat::CHECKBOX, 'string|nullable');
    }

    /**
     * Форма регистрации
     *
     * @return void
     */
    protected function form_signup(): void {
        $this->definition->add('login', __('user.login'), [],
            FormElementsFormat::TEXT, 'required|max:255|unique:users,login');
        $this->definition->add('email', __('user.email'), [],
            FormElementsFormat::TEXT, 'required|email|unique:users,email');
        $this->definition->add('password', __('user.create_password'), [],
            FormElementsFormat::TEXT, 'string|min:8|required');
        $this->definition->add('policyagreed', __('user.agree_privacy_policy_on_signup'),
            ['has_link' => true], FormElementsFormat::CHECKBOX, 'string|required');
    }

    /**
     * Форма сброса пароля
     *
     * @return void
     */
    protected function form_reset_password(): void
    {
        $this->definition->add('email', __('user.email'), [],
            FormElementsFormat::TEXT, 'required|email');
        $this->definition->add('password', __('user.new_password'), [], FormElementsFormat::TEXT,
            'string|min:8|required');
        $this->definition->add('password_confirmation', __('user.password_confirmation'), [], FormElementsFormat::TEXT,
            'string|min:8|required|same:password');
    }

    protected function validation(array &$data): void {
        //
    }

    public function addFilesDefinitions($name, $files): void
    {
        $this->extra[$name] = $files;
    }


}
