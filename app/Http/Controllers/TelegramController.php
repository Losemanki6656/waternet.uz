<?php

namespace App\Http\Controllers;

use App\Models\ClientChat;
use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function send(Request $request)
    {


        $url = null;
        if ($request->photo) {
            $fileName = auth()->user()->id . time() . '.' . $request->photo->extension();
            $path = $request->photo->storeAs('photos', $fileName);
            $url = url(asset('storage/' . $path));
        }

        try {
            $clients = ClientChat::whereIn('id', $request->checkbox)
                ->with('client')
                ->get();
            $user = auth()->user()->id;
            $org = auth()->user()->organization_id;

            if ($url && $request->message) {
                foreach ($clients as $item) {

                    Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendPhoto', [
                        'chat_id' => $item->chat_id,
                        'caption' => $request->message,
                        'photo' => $url
                    ]);

                    Sms::create([
                        'organization_id' => $org,
                        'client_id' => $item->client_id,
                        'client_chat_id' => $item->id,
                        'user_id' => $user,
                        'city_id' => $item->client->city_id,
                        'area_id' => $item->client->area_id,
                        'fullname' => $item->client->fullname,
                        'phone' => $item->phone,
                        'sms_text' => $request->message,
                        'type' => 1,
                        'photo' => $path
                    ]);
                }
            } else if (!$url && $request->message) {
                foreach ($clients as $item) {
                    Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendMessage', [
                        'chat_id' => $item->chat_id,
                        'text' => $request->message,
                        "parse_mode" => "HTML",
                    ]);

                    Sms::create([
                        'organization_id' => $org,
                        'client_id' => $item->client_id,
                        'client_chat_id' => $item->id,
                        'user_id' => $user,
                        'city_id' => $item->client->city_id,
                        'area_id' => $item->client->area_id,
                        'fullname' => $item->client->fullname,
                        'phone' => $item->phone,
                        'sms_text' => $request->message,
                        'type' => 1
                    ]);
                }
            } else if ($url && !$request->message) {
                foreach ($clients as $item) {
                    Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendPhoto', [
                        'chat_id' => $item->chat_id,
                        'photo' => $url
                    ]);

                    Sms::create([
                        'organization_id' => $org,
                        'client_id' => $item->client_id,
                        'client_chat_id' => $item->id,
                        'user_id' => $user,
                        'city_id' => $item->client->city_id,
                        'area_id' => $item->client->area_id,
                        'fullname' => $item->client->fullname,
                        'phone' => $item->phone,
                        'sms_text' => '',
                        'type' => 1,
                        'photo' => $path
                    ]);
                }
            }

            return redirect()->back()->with('success', __('messages.message_successfully_sent'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function index()
    {

        $result = json_decode(file_get_contents('php://input'));

        $action = $result->message->text;
        $userID = $result->message->from->id;

        if ($action == '/start') {

            $client = ClientChat::where('chat_id', $userID)->first();
            if ($client) {
                Http::post('https://api.telegram.org/bot6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY/sendMessage', [
                    'chat_id' => $userID,
                    'text' => 'Assalom aleykum ' . $client->name . '. Bizning Waternet botimizga xush kelibsiz!',
                    "parse_mode" => "HTML",
                    'reply_markup' => $this->keyBoard()
                ]);
            } else {
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
        // $option = [
        //     [
        //         "🛍 Mahsulotlar",
        //         "📗 Buyurtmalarim"
        //     ],
        //     [
        //         "✅ Ma'lumotlarim",
        //         "⤵️ Profildan chiqish"
        //     ]
        // ];


        // $keyboard = [
        //     'keyboard' => $option,
        //     'resize_keyboard' => true,
        //     'one_time_keyboard' => true,
        //     'selective' => true
        // ];

        $keyboard = array(
            "inline_keyboard" => array(
                [
                    [
                        "text" => "1",
                        "callback_data" => "rate_1"
                    ],
                    [
                        "text" => "2",
                        "callback_data" => "rate_2"
                    ],
                    [
                        "text" => "3",
                        "callback_data" => "rate_3"
                    ],
                    [
                        "text" => "4",
                        "callback_data" => "rate_4"
                    ],
                    [
                        "text" => "5",
                        "callback_data" => "rate_5"
                    ]
                ],
                [
                    [
                        "text" => "6",
                        "callback_data" => "rate_6"
                    ],
                    [
                        "text" => "7",
                        "callback_data" => "rate_7"
                    ],
                    [
                        "text" => "8",
                        "callback_data" => "rate_8"
                    ],
                    [
                        "text" => "9",
                        "callback_data" => "rate_9"
                    ]
                ]
            )
        );

        $keyboard = json_encode($keyboard);

        return $keyboard;
    }
}