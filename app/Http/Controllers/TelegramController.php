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
        $chat_id = $bot->getChat(['chat_id' => $request->chat_id]);
        Log::info($chat_id);
       
    }
}
