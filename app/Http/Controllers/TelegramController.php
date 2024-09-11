<?php

namespace App\Http\Controllers;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $bot = Telegram::bot('mybot');
        $update = $bot->getWebhookUpdate();
        $chat_id = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        if($text == '/start'){
            $bot->sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Welcome to our bot!'.$update->getMessage()->getChat()->getFirstName(),
            ]);
        }
       
    }
}
