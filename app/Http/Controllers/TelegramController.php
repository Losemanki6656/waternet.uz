<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function send()
    {
        $res = Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/setWebhook', [
            'url' => url(route('webhook'))
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
        $action = $result->message->text;
        $userID = $result->message->from->id;

        if ($action == '/start') {
            Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
                'chat_id' => $userID,
                'text' => 'salom'
            ]);
        }
    }
}