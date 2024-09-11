<?php

namespace App\Http\Controllers;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;
class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $bot = Telegram::bot('mybot');
        $update = $bot->getWebhookUpdate();
        $message = $update->getMessage();
        $chat = $message->getChat();
        $chatId = $chat->getId();

        if ($message->getText() === '/start') {
            // Path to your photo

            // Send the photo
            $bot->sendPhoto([
                'chat_id' => $chatId,
                'photo' => "https://images.pexels.com/photos/674010/pexels-photo-674010.jpeg?cs=srgb&dl=pexels-anjana-c-169994-674010.jpg&fm=jpg",
                'caption' => 'Welcome to our bot! Here\'s a greeting photo.',
            ]);
        }
    }
}
