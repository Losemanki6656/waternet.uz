<?php

namespace App\Http\Controllers;

use App\Models\ClientChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function send()
    {
    
        $res = Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/setWebhook', [
            'url' => 'https://cadry.waternet.uz/api/6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY'
        ]);

        dd($res->body());
    }

    public function index()
    {

        $result = json_decode(file_get_contents('php://input'));
        
        $action = $result->message->text;
        $userID = $result->message->from->id;

        if ($action == '/start') {

            $client = ClientChat::where('chat_id', $userID)->first();
            if($client) {
                Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
                    'chat_id' => $userID,
                    'text' => 'Assalom aleykum '. $client->name . '. Bizning Waternet botimizga xush kelibsiz!',
                    "parse_mode" => "HTML",
                    'reply_markup' => $this->keyBoard()
                ]);
            }
            else {
                Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/setWebhook', [
                    'url' => url(route('webhook_tg_login'))
                ]);

                Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
                    'chat_id' => $userID,
                    'text' => "Assalom aleykum. Bizning Waternet botimizga xush kelibsiz! Iltimos Botdan to'liq foydalanish uchun ro'yxatdan o'ting! <br> Waternet saytidagi loginni kiriting...",
                    "parse_mode" => "HTML",
                ]);
            }
           
        }
    }

    public function login()
    {

        Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
            'chat_id' => 5011373330,
            'text' => 'login'
        ]);
    }

    public function keyBoard()
    {
        $option = [
            [
                "🛍 Mahsulotlar", "📗 Buyurtmalarim"
            ],
            [
                "✅ Ma'lumotlarim", "⤵️ Profildan chiqish"
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

        return $keyboard;
    }
}