<?php

namespace Source\Event;

use Source\Entity\Admin\Models\Moderation;
use Source\Entity\User\Dictionaries\UserStatus;

class ItemModerated
{
    private string $status;
    public function __construct(public Moderation $moderation)
    {
        $this->status = $moderation->other->status;
    }

    /**
     * Получить проставленный статус пользователя
     *
     * @return mixed
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
