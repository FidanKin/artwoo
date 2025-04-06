<?php

namespace Source\Auth\Dictionaries;

/**
 * Статусы аутентификации
 *
 * oauth2 - через сторонные сервисы по протоколу oauth2
 * manual - ручная регистрация
 */
enum AuthType: string
{
    case OAUTH2 = 'oauth2';
    case MANUAL = 'manual';
}
