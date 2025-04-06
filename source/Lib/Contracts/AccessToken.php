<?php

namespace Source\Lib\Contracts;

interface AccessToken
{
    public function canAccess(string $token, int $source): bool;
    public function isExpired(string $token): bool;
    public function cron(): void;
    public function save(string $token, int $source): bool;
}
