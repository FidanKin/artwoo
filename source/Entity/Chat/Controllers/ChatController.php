<?php

namespace Source\Entity\Chat\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Source\Entity\Chat\Events\ChatCreated;
use Source\Entity\Chat\Models\Chat;
use Source\Entity\Chat\Models\ChatMessage;
use Source\Entity\Chat\Models\ChatUser;
use Source\Entity\Chat\Templates\MessagesOutput;
use Source\Entity\Chat\Templates\SendMessageForm;
use Source\Entity\User\Models\User;
use Source\Helper\Enums\Crud;
use Source\Helper\FormObjectTransfer\DataDefinition;

use Source\Lib\Contracts\Navigation;
use Source\Lib\DTO\NavigationItemDTO;
use function Source\Lib\FormState\artwooSessionFormFailed;
use function Source\Lib\FormState\artwooSessionFormSaved;
use function Source\Lib\FormState\artwooSessionResolveState;

class ChatController extends \App\Http\Controllers\Controller
{
    public function index(User $user, Navigation $navigation): \Illuminate\Contracts\View\View
    {
        $chats = $user->chatUsers;

        $template = MessagesOutput::previewAllUserChats(
            ChatMessage::getUserLatestMessageFromAllChats($user->id),
            $user
        );

        $navigation
            ->add(new NavigationItemDTO('/my', __('user.navigation.my_page')))
            ->add(new NavigationItemDTO('/chat', __('chat.navigation.all'), true));

        return view('pages.user-chats', [
            'chats' => $chats,
            'isEmpty' => $chats->isEmpty(),
            'chatMessages' => $template,
            'navigation' => $navigation->build()
        ]);
    }

    /**
     * @param  int  $id - идентификатор чата
     */
    public function showMessages(User $user, Navigation $navigation, int $id): \Illuminate\Contracts\View\View
    {
        if (! Chat::find($id)) {
            abort(404);
        }

        $interlocutor = ChatUser::getInterlocutorFromChat($id, $user);
        if (! $interlocutor) {
            abort(404);
        }

        $interlocutorPreview = [
            'id' => $interlocutor->id,
            'login' => $interlocutor->login,
            'icon' => $interlocutor->getIconUrl(),
        ];
        // получить все сообщения по идентификатору чата в следующем виде:
        // [user_id => message]
        // https://tailwindcss.com/docs/hover-focus-and-other-states#first-last-odd-and-even
        $messages = ChatMessage::getChatMessages($id);

        $formInstance = new SendMessageForm(new DataDefinition());

        $navigation->addMyNode()
            ->add(new NavigationItemDTO('/chat', __('chat.navigation.all')))
            ->add(new NavigationItemDTO("/chat/{$id}", __('chat.navigation.single',
                ['username' => $interlocutor->login]), true));

        return view('pages/chat', [
            'messages' => MessagesOutput::prepareForView($messages, $user, $interlocutor),
            'formData' => $formInstance->export('send_message'),
            'interlocutor' => $interlocutorPreview,
            'chatId' => $id,
            'formState' => artwooSessionResolveState(),
            'navigation' => $navigation->build(),
        ]);
    }

    public function createChat(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'to_user' => 'required|integer',
        ]);

        if ($chatId = Chat::createPrivate($user->id, $data['to_user'])) {
            return artwooSessionFormSaved("/chat/{$chatId}", __('chat.actions.chat_created'));
        } else {
            return artwooSessionFormFailed(__('chat.actions.cannot_create_folder'));
        }
    }

    public function addMessage(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'message' => 'required|string|max:6000',
            'to_user' => 'required|integer',
        ]);

        try {
            ChatMessage::sendMessage($data['to_user'], $user->id, $data['message']);
        } catch (QueryException $exception) {
            Log::warning('Cannot save message. Data: from_user: {from}, message: {message}', [
                'from' => $user->id,
                'message' => $exception->getMessage(),
            ]);

            return artwooSessionFormFailed(__('chat.actions.cannot_send_message'));
        }

        return redirect()->back();
    }

    public function deleteChat(int $id): RedirectResponse
    {
        if (Chat::deleteUserChat($id)) {
            return artwooSessionFormSaved('/chat', __('chat.actions.chat_was_delete'));
        }

        return artwooSessionFormFailed(__('chat.actions.cannot_delete_chat'));
    }
}
