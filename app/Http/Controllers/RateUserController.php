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
    
    public function index()
    {
        $rates = RateUser::where('status', false);
        $newMessages = [];
        if($rates->count())
        {
            $arr = [];
            foreach ($rates->get() as $item) {
                $tg = ClientChat::where('client_id', $item->client_id)->first();
                if($tg) {

                    $order = SuccessOrders::find($item->success_order_id);
        
                    $text = "Получено - ".$order->amount.", Доставлено - ".$order->count.", Возврат тар - ".
                    $order->container.", Предоплата ".Client::find($order->client_id)->balance.". Спасибо за покупки!";

                    $arr[] = [
                        'id' => $item->id,
                        'message' => $text,
                        'chat_id' => $tg->chat_id,
                        'rate_msg' => 'Доставшик хизматини бахоланг ...'
                    ];
                }

            }

            $newMessages[] = [
                'type' => 'rate',
                'data' => $arr
            ];
        }

        $sms = Sms::take(3);

        if($sms->count()) {
            $arr = [];
            foreach ($sms->get() as $s) {
                $tg = ClientChat::where('client_id', $s->client_id)->first();
                if($tg) {

                    $arr[] = [
                        'message' => 'message',
                        'chat_id' => $tg->chat_id,
                        'photo' => 'https://yobte.ru/uploads/posts/2019-11/devushki-v-lesu-75-foto-62.jpg'
                    ];
                }

            }

            $newMessages[] = [
                'type' => 'newMessage',
                'data' => $arr
            ];
        }
       

        return response()->json([
            'messages' => $newMessages
        ]);
    } 

    public function update($rate)
    {
        $rates = RateUser::findOrFail($rate);

        $rates->status = true;
        $rates->comment = request('comment','');
        $rates->save();

        return response()->json([
            'message' => 'success'
        ]);
    } 
}
