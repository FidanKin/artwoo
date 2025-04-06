<?php

namespace Source\Entity\User\Dictionaries;

/**
 * Статусы пользователя
 * draft - пользователь заполнил не все поля, доступ к части функционала ограничен.
 * blocked - пользователь заблокирован, т.к. его действия вызывали опасения со стороны платформы
 * active - пользователь полностью заполнил все поля, он полноценно пользуется платформой
 * deleted - пользователь удален, т.к. он решил удалить аккаут или действия вызывали опасения
 */
enum UserStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case DELETED = 'deleted';

    public static function select(): array
    {
        $select = [];

        foreach (UserStatus::cases() as $value) {
            $select[$value->value] = ucfirst($value->value);
        }

        return $select;
    }
}
