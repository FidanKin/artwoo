<?php

namespace Source\Entity\Chat\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ItemNotFoundException;
use Source\Entity\Chat\Events\ChatCreated;
use Source\Entity\User\Models\User;
use Source\Helper\Enums\Crud;

class ChatMessage extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['user_id', 'chat_id', 'message'];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Отправить сообщение в чат от указанного пользователя
     * Событие модели не выбрасывается
     */
    public static function sendMessage(int $toUserId, int $fromUserId, string $message): bool
    {
        try {
            $chatId = ChatUser::twoUsersChat($toUserId, $fromUserId);
        } catch (ItemNotFoundException) {
            // чата нет, создадем его
            $chatId = Chat::createPrivate($toUserId, $fromUserId);
            ChatCreated::dispatch(Crud::CREATE, $chatId, $fromUserId, [], request()->ip());
            if (! $chatId) {
                return false;
            }
        }

        $chatMessage = new static(['chat_id' => $chatId, 'user_id' => $fromUserId, 'message' => $message]);

        return $chatMessage->saveQuietly();
    }

    /**
     * Получить последние сообщения из чата по выбранному пользователю
     * Возможно, запрос не идеален ...
     * В начале получаем максимальный id сообщения по каждому чату
     * Затем выполняем запрос на получение данных по данным id
     *
     * Возможн, можно закешировать для каждого пользователя
     */
    public static function getUserLatestMessageFromAllChats(int $userId): array
    {
        $chatMessagesTableName = DB::getTablePrefix().(new ChatMessage())->getTable();

        return ChatMessage::whereIn('id',
            ChatUser::where('chat_users.user_id', '=', $userId)
                ->join('chat_messages', 'chat_messages.chat_id', '=', 'chat_users.chat_id')
                ->groupBy('chat_users.chat_id')
                ->select(DB::raw("MAX({$chatMessagesTableName}.id) as chat_message_id"))
        )->orderBy('created_at', 'desc')->get()->toArray();
    }

    public static function getChatMessages(int $chatId): array
    {
        return static::where('chat_id', '=', $chatId)->select(['user_id', 'message', 'created_at'])->get()->toArray();
    }
}
