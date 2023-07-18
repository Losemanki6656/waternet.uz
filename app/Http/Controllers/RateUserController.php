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
        $rates = RateUser::where('client_id', request('client_id',0))
            ->where('status', false);

        $tg = ClientChat::where('client_id', request('client_id'))->first();

        $newMessages = [];
        if($rates->count())
        {
            $arr = [];
            foreach ($rates->get() as $item) {
                if($tg) {

                    $order = SuccessOrders::find($item->success_order_id);
        
                    $text = "Получено - ".$order->amount.", Доставлено - ".$order->count.", Возврат тар - ".
                    $order->container.", Предоплата ".Client::find($order->client_id)->balance.". Спасибо за покупки!";

                    $arr[] = [
                        'id' => $item->id,
                        'message' => $text,
                        'rate_msg' => 'Доставшик хизматини бахоланг ...',
                        'chat_id' => $tg->chat_id
                    ];
                }

            }

            $newMessages[] = [
                'type' => 'rate',
                'data' => $arr
            ];
        }

        $sms = Sms::where('client_id', request('client_id',0));

        if($sms->count()) {
            $arr = [];
            foreach ($sms->get() as $item) {
                if($tg) {

                    $arr[] = [
                        'message' => 'message',
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
