<?php

namespace Source\Entity\Resume\Dictionaries;

/**
 * Предпочитаемая сфера работы
 */
enum PreferredWork: string
{
    case PAINTINGS = 'paintings'; // картины
    case DESIGNS = 'designs'; // изделия ручной работы
    case PHOTOS = 'photos'; // фотографии
    case SCULPTURES = 'sculptures'; // скульптор или скульптура

    /**
     * Получение отображаемого значения для профиля пользователя
     *
     * @return array
     */
    public static function getSelectList(): array {
        return [
            PreferredWork::PAINTINGS->value => __("resume.preferred_work_list.paintings"),
            PreferredWork::DESIGNS->value => __("resume.preferred_work_list.designs"),
            PreferredWork::SCULPTURES->value => __("resume.preferred_work_list.sculptures"),
        ];
    }
}
