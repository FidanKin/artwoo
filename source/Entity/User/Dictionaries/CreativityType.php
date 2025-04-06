<?php

/**
 * Категории творчества
 */
namespace Source\Entity\User\Dictionaries;

enum CreativityType: string
{
    case PICTURE = 'picture'; // художник или картина
    case HANDMADE = 'handmade'; // дизайнер или дизайнерская работа
    case SCULPTURE = 'sculpture'; // скульптор или скульптура

    /**
     * Получение отображаемого значения для профиля пользователя
     *
     * @return string
     */
    public function getAuthorCreativityName(): string {
        return match ($this) {
            CreativityType::PICTURE => __("user.creativity_picture"),
            CreativityType::HANDMADE => __("user.creativity_handmade"),
            CreativityType::SCULPTURE => __("user.creativity_sculptor"),
        };
    }

    /**
     * Получение отображаемого значения для отображения работы
     *
     * @return string
     */
    public function getArtworkCreativityName(): string {
        return match ($this) {
            CreativityType::PICTURE => __("artwork.types.picture"),
            CreativityType::HANDMADE => __("artwork.types.handmade"),
            CreativityType::SCULPTURE => __("artwork.types.sculpture"),
        };
    }
}
