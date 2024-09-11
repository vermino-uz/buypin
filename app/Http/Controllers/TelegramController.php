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
        $chat = $update->getMessage()->getChat()->getId();
        $message = $update->getMessage()->getText();
        Log::info($chat);
        Log::info($message);

        // Log::info($chat_id);
       
    }
}
