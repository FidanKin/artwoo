<?php

namespace Source\Lib\Api;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Source\Lib\Contracts\AccessToken;
use Illuminate\Support\Facades\DB;

class UserAccessToken implements AccessToken
{
    private string $table = 'user_access_token';
    private Builder $db;

    public function __construct()
    {
        $this->db = DB::table($this->table);
    }

    public function canAccess(string $token, int $source): bool
    {
        $row = $this->db->where('token', $token)->first();

        if ( ! $row) {
            return false;
        }

        if ((int) $row->user_id != $source) {
            return false;
        }

        return true;
    }

    public function isExpired(string $token): bool
    {
        return false;
//        return $this->db->where('token', '=', $token)
//            ->where('created_at', '>=', $this->expiredAt())->exists();
    }

    public function cron(): void
    {
        $this->db->where('created_at', '<', $this->expiredAt())->delete();
    }

    public function save(string $token, int $source): bool
    {
        if (! $this->db->where('user_id', $token)->exists()) {
            return $this->db->insert(['token' => $token, 'user_id' => $source]);
        }

        return true;
    }

    protected function expiredAt(): string
    {
        $currentTime = new \DateTimeImmutable();
        return $currentTime->sub(new \DateInterval('P1D'))->format(config('app.artwoo.date.mysql_format_datetime'));
    }

    /**
     * Сгенерировать токен
     *
     * @return string
     */
    public static function generateToken(): string
    {
        return Str::random(64);
    }
}
