<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->setWebhook(['url' => env('TELEGRAM_WEBHOOK_URL')]);
    }
}
