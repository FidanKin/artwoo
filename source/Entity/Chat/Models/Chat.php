<?php

namespace Source\Entity\Chat\Models;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Chat extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name', 'type', 'is_active', 'admin_id'];

    private const TYPE_PRIVATE = 'private';

    private const TYPE_GROUP = 'group';

    protected $casts = ['is_active' => 'boolean'];

    /**
     * Создание приватного чата (только для двух участников)
     * Названия у такого чата нет
     */
    public static function createPrivate(int $user1, int $user2): int|false
    {
        try {
            $chat = new static(['name' => 'Чат', 'type' => static::TYPE_PRIVATE]);
            $chat->save();
            $chatId = $chat->id;
            // добавляем пользователей в чат
            ChatUser::insert([
                ['chat_id' => $chatId, 'user_id' => $user1],
                ['chat_id' => $chatId, 'user_id' => $user2],
            ]);

            return $chatId;
        } catch (QueryException $exception) {
            Log::warning("Cannot create chat. Data: users: {users}, message: {$exception->getMessage()}",
                ['users' => "$user1, $user2"]);

            return false;
        }
    }

    public static function createRoom(string $name, int $adminID)
    {
        // пока не актуально
    }

    public static function deleteUserChat(int $chatId): bool
    {
        $chat = static::find($chatId);
        if (! $chat) {
            return true;
        }

        return $chat->delete();
    }
}
