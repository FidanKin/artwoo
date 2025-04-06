<?php

namespace Source\Entity\Chat\Templates;

use Source\Entity\Chat\Models\ChatUser;
use Source\Entity\User\Models\User;

use function Source\Helper\artwooSimpleDatetimeToHumanDatetime;
use function Source\Lib\Text\artwooShortText;

class MessagesOutput
{
    /**
     * Подготовить сообщения выбранного чата для отображения
     *
     * @param  array  $messages - все сообщения из чата
     * @param  User  $currentUser -  текущий пользователь, открывший чат
     * @param  User  $interlocutor - собеседник в чате
     */
    public static function prepareForView(array $messages, User $currentUser, User $interlocutor): array
    {
        $userTemplate = [
            $currentUser->id => [
                'icon' => $currentUser->getIconUrl(),
            ],
            $interlocutor->id => [
                'icon' => $interlocutor->getIconUrl(),
            ],
        ];

        $currentUserId = $currentUser->id;
        foreach ($messages as &$message) {
            $viewerMessage = true;
            if ($message['user_id'] !== $currentUserId) {
                $viewerMessage = false;
            }

            $message['user_icon'] = $userTemplate[$message['user_id']]['icon'];
            $message['viewer_message'] = $viewerMessage;
        }

        return $messages;
    }

    /**
     * Получить данные для view отображения всех чатов с последним сообщением
     *
     * @param  \Source\Entity\User\Models\User  $interlocutor
     */
    public static function previewAllUserChats(array $messages, User $currentUser): array
    {
        $chats = [];

        foreach ($messages as &$message) {
            $interlocutor = ChatUser::getInterlocutorFromChat($message['chat_id'], $currentUser);
            $message['message'] = artwooShortText($message['message'], 150);
            $message['created_at'] = artwooSimpleDatetimeToHumanDatetime($message['created_at']);
            $chats[$message['chat_id']] = [
                'message' => $message,
                'to_user' => [
                    'id' => $interlocutor->id,
                    'icon' => $interlocutor->getIconUrl(),
                    'age' => $interlocutor->getAge(),
                    'login' => $interlocutor->login,
                ],
            ];
        }

        return $chats;
    }
}
