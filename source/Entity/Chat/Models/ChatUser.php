<?php

namespace Source\Entity\Chat\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\JoinClause;
use Source\Entity\User\Models\User;

class ChatUser extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['user_id', 'chat_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Возвращает идентификатора пользователей в указанном чате
     */
    public static function getUsersInChat(int $chatId): array
    {
        return static::where('chat_id', '=', $chatId)->get()->pluck('user_id')->all();
    }

    public static function isUserInChat(int $userId, int $chatId): bool
    {
        $chatCollection = static::where('chat_id', '=', $chatId)->select(['user_id'])->get();

        return $chatCollection->contains(function ($model) use ($userId) {
            return $model->user_id === $userId;
        });
    }

    /**
     * Метод проверяет, состоят ли два пользователя в чате
     *
     *
     * @return int - идентификатор чата
     *
     * @throws \Illuminate\Support\ItemNotFoundException - в случае, если чата нет
     */
    public static function twoUsersChat(int $userId1, int $userId2): int
    {
        $chatUser = static::where('chat_users.user_id', '=', $userId1)
            ->join('chat_users as cu2', function (JoinClause $join) use ($userId2) {
                $join->on('chat_users.chat_id', '=', 'cu2.chat_id')
                    ->where('cu2.user_id', '=', $userId2);
            })->select('cu2.*')->get()->firstOrFail();

        return $chatUser->chat_id;
    }

    /**
     * Поучить собеседника из чата согласно текущему пользователю
     */
    public static function getInterlocutorFromChat(int $chatId, User $currentUser): User|false
    {
        $userIdsInChat = static::getUsersInChat($chatId);
        $diff = array_diff($userIdsInChat, [$currentUser->id]);
        $interlocutorId = array_shift($diff);

        if ($interlocutorId === null) {
            return false;
        }

        return User::find($interlocutorId);
    }
}
