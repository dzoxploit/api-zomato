<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramBotController extends Controller
{
    protected $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handleRequest(Request $request)
    {
        $update = $this->telegram->getWebhookUpdate();

        if (isset($update['message']['text'])) {
            // Handle text messages
            $text = $update['message']['text'];
            $this->handleTextMessage($text);
        }

        // Handle other message types (location, contact, video, etc.)
    }

    private function handleTextMessage($text)
    {
        // Process the user's text message and respond accordingly
        $response = 'Your message: ' . $text;
        $chatId = $this->telegram->getWebhookUpdate()['message']['chat']['id'];

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $response,
        ]);
    }
}
