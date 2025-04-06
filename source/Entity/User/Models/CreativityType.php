<?php

namespace Source\Entity\User\Models;

/**
 * Класс для работы с категориями творчества. Их у нас 4:
 *  Картина, фотография, скульптура, дизайн
 */
class CreativityType
{
    // художник или картина
    const CREATIVITY_DEFAULT = 'picture';

    public function __construct(private readonly \Source\Entity\User\Dictionaries\CreativityType $type
    ) {

    }

    public function getAuthorName(): string {
        return $this->type->getAuthorCreativityName();
    }

    /**
     * Список для использования в поле пользователя
     *
     * @return array
     */
    public static function getAuthorCreativityList(): array {
        return [
          \Source\Entity\User\Dictionaries\CreativityType::PICTURE->value => __("user.creativity_picture"),
          \Source\Entity\User\Dictionaries\CreativityType::HANDMADE->value => __("user.creativity_handmade"),
          \Source\Entity\User\Dictionaries\CreativityType::SCULPTURE->value => __("user.creativity_sculptor"),
        ];
    }
}
