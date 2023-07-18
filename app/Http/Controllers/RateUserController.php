<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientChat;
use App\Models\RateUser;
use App\Models\SuccessOrders;
use Illuminate\Http\Request;

class RateUserController extends Controller
{
    
    public function index()
    {
        $rates = RateUser::where('client_id', request('client_id',0))
            ->where('status', false)
            ->get();

        $arr = [];
        foreach ($rates as $item) {
            $tg = ClientChat::where('client_id', request('client_id'))->first();
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

        return response()->json([
            'data' => $arr
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
