<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use Telegram\Bot\Laravel\Facades\Telegram;

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
        // Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
        //     'chat_id' => 5011373330,
        //     'text' => 'waternet'
        // ]);


        $result = json_decode(file_get_contents('php://input'));
        
        $action = $result->message->text;
        
        Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
            'chat_id' => 5011373330,
            'text' => $action
        ]);

        $userID = $result->message->from->id;

        if ($action == '/start') {

            $keyboard = [
                ['7', '8', '9'],
                ['4', '5', '6'],
                ['1', '2', '3'],
                     ['0']
            ];
            
            $reply_markup = Telegram::replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ]);
            
            $response = Telegram::sendMessage([
                'chat_id' => $userID,
                'text' => 'Hello World',
                'reply_markup' => $reply_markup
            ]);
            
            // $text = "Hello";
            // $option = [
            //     [
            //         'text' => 'Mening',
            //         'url' => 'sadasd'
            //     ],
            //     [
            //         'text' => '789',
            //         'url' => '12313'
            //     ],
            // ];

            // $keyboard = [
            //     'keyboard' => $option,
            //     'resize_keyboard' => true,
            //     'one_time_keyboard' => true,
            //     'selective' => true
            // ];

            // $keyboard = json_encode($keyboard);

            // Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
            //     'chat_id' => $userID,
            //     'text' => 'Hello',
            //     'reply_markup' => $keyboard
            // ]);
        }
    }
}