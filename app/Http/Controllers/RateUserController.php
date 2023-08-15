<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientChat;
use App\Models\RateUser;
use App\Models\Sms;
use App\Models\SuccessOrders;
use Illuminate\Http\Request;

class RateUserController extends Controller
{

    public function coming_son()
    {
        return view('comins_son');
    }


    public function index()
    {
        $rates = RateUser::where('status', false);
        $newMessages = [];
        if ($rates->count()) {
            $arr = [];
            foreach ($rates->get() as $item) {
                $tg = ClientChat::where('client_id', $item->client_id)->first();
                if ($tg) {

                    $order = SuccessOrders::find($item->success_order_id);

                    $text = "Получено - " . $order->amount . ", Доставлено - " . $order->count . ", Возврат тар - " .
                        $order->container . ", Предоплата " . Client::find($order->client_id)->balance . ". Спасибо за покупки!";

                    $arr[] = [
                        'id' => $item->id,
                        'message' => $text,
                        'chat_id' => $tg->chat_id,
                        'rate_msg' => 'Доставшик хизматини бахоланг ...'
                    ];
                }

            }
            if (count($arr))
                $newMessages[] = [
                    'type' => 'rate',
                    'data' => $arr
                ];
        }

        $sms = Sms::take(3);

        if ($sms->count()) {
            $arr = [];
            foreach ($sms->get() as $s) {
                $tg = ClientChat::where('client_id', $s->client_id)->first();
                if ($tg) {

                    $arr[] = [
                        'message' => 'message',
                        'chat_id' => $tg->chat_id,
                        'photo' => 'https://yobte.ru/uploads/posts/2019-11/devushki-v-lesu-75-foto-62.jpg'
                    ];
                }

            }

            if (count($arr))
                $newMessages[] = [
                    'type' => 'newMessage',
                    'data' => $arr
                ];
        }


        return response()->json([
            'messages' => $newMessages
        ]);
    }

    public function update($client_id, Request $request)
    {

        $callback = explode('_', $request->callback);

        $comment = request('comment');
        if ($comment == 'No comment')
            $comment = '';

        $rates = RateUser::find($callback[3]);
        $rates->rate = $callback[2];
        $rates->status = true;
        $rates->comment = $comment;
        $rates->save();

        return response()->json([
            'message' => 'Бизнинг хизматдан фойдаланганингиз учун рахмат!'
        ]);
    }

    public  function  delete_client($chat_id)
    {
        ClientChat::where('chat_id', $chat_id)
            ->update([
                'status' => false
            ]);

        return response()->json([
            'message' => 'Deleted Successfully!'
        ]);
    }
}
