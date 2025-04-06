<?php

namespace App\Listeners;

use Source\Entity\User\Dictionaries\UserStatus;
use Source\Entity\User\Models\User;
use Source\Event\ItemModerated;

/**
 * Обновляем статус пользователя
 */
class UpdateUserStatus
{
    public function handle(ItemModerated $event): void
    {
        if ($event->moderation->component === 'user') {
            // object_id идентификатор пользователя
            $user = User::find($event->moderation->object_id);

            if ($user) {
                if (! in_array($event->getStatus(), array_keys(UserStatus::select()))) {
                    return;
                }
                $user->status = $event->getStatus();
                $user->save();
                User::getCountedAuthors(true);
            }
        }
    }
}
