<?php

namespace Source\Entity\User\Templates;

use Source\Entity\User\Models\User;

class Output
{
    public function __construct(private readonly User $user)
    {

    }

    /**
     * Получить данные автора для передачи по view
     *
     * @return array
     */
    public function authorContext(): array
    {
        $additional['creativity_name'] = $this->user->getCreativityLangString();
        $additional['age'] = $this->user->getAge();
        $additional['avatar_icon'] = $this->user->getIconUrl();
        $additional['socials'] = $this->user->getSocialsLink();
        return array_merge($this->user->toArray(), $additional);
    }
}
