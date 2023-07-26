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
        $x = public_path('assets\images\bg-1.jpg');

        $response = Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendPhoto', [
            'chat_id' => 5011373330,
            'photo' => 'https://cdn.dribbble.com/users/1556616/screenshots/4393685/attachments/999670/as_logo_pure.jpg',
        ]);

        // $response = Telegram::sendPhoto([
        //     'chat_id' => 5011373330,
        //     'photo' => 'https://cdn.dribbble.com/users/1556616/screenshots/4393685/attachments/999670/as_logo_pure.jpg',
        //     'caption' => 'Some caption'
        // ]);
        dd($response);
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

            $text = "Hello";
            $option = [
                [
                    "🛍 Mahsulotlar", "Buyurtmalarim"
                ],
                [
                    "Ma'lumotlarim", "Profildan chiqish"
                ]
            ];

            // $keyboard = array(
            //     "inline_keyboard" => array(
            //         array(
            //             array(
            //                 "text" => "My Button Text", 
            //                 "callback_data" => "myCallbackData"
            //             )
            //         )
            //     )
            // );

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
                "parse_mode" => "HTML",
                'reply_markup' => $keyboard
            ]);
        }
    }
}