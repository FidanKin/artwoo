<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Source\Entity\Chat\Models\Chat as ChatModel;
use Source\Entity\Chat\Models\ChatMessage;

class Chat extends Seeder
{
    /**
     * Run the database seeds.
     * !!! Не запускать в продакшене!!!
     */
    public function run(): void
    {
        $this->fillChats();
        $this->fillUserMessages();
    }

    private function fillChats(): void {
        ChatModel::createPrivate(1, 2);
        ChatModel::createPrivate(1, 3);
    }

    private function fillUserMessages(): void {
        ChatMessage::sendMessage(1, 1, "hello1");
        ChatMessage::sendMessage(1, 1, "hello2");
        ChatMessage::sendMessage(1, 2, "hello3");
        ChatMessage::sendMessage(1, 2, "hello4");
        ChatMessage::sendMessage(2, 1, "hello5");
        ChatMessage::sendMessage(2, 1, "hello6");
        ChatMessage::sendMessage(2, 3, "hello7");
        ChatMessage::sendMessage(2, 3, "hello8");
    }
}
