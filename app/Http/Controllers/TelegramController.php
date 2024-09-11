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
            $bot->sendPhoto([
                'chat_id' => $chat_id,
                'photo' => \Telegram\Bot\FileUpload\InputFile::create('https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'),
                'caption' => 'Welcome to our bot!',
            ]);

        }
       
    }
}
