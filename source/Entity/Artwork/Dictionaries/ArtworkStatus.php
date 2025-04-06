<?php

namespace Source\Entity\Artwork\Dictionaries;

enum ArtworkStatus: string
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case BLOCKED = 'blocked';
    public static function select(): array
    {
        $select = [];

        foreach (ArtworkStatus::cases() as $value) {
            $select[$value->value] = ucfirst($value->value);
        }

        return $select;
    }

}
