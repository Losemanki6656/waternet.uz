<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function send()
    {
        // $res = Http::get('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/getWebhookInfo');

        // dd($res->body());

        $res = Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/setWebhook', [
            'url' => 'https://cadry.waternet.uz/api/6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY'
        ]);

        dd($res->body());
    }

    public function index()
    {
        Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
            'chat_id' => 5011373330,
            'text' => 'waternet'
        ]);


        $result = json_decode(file_get_contents('php://input'));
        Log::info($result);
        
        $action = $result->message->text;
        $userID = $result->message->from->id;

        if ($action == '/info1') {
            Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
                'chat_id' => 5011373330,
                'text' => 'info1'
            ]);
        }

        if ($action == '/start') {
            $text = "Hello";
            $option = [
                ['info1', 'info2'],
                ['info3', 'info4']
            ];

            $keyboard = [
                'keyboard' => $option,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
                'selective' => true
            ];

            $keyboard = json_encode($keyboard);

            Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
                'chat_id' => $userID,
                'text' => 'Hello',
                'reply_markup' => $keyboard
            ]);
        }
    }
}