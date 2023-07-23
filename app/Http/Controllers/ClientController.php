<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientPrices;
use App\Models\ClientContainer;
use App\Models\UserOrganization;
use App\Models\Organization;
use App\Models\Order;
use App\Models\TakeProduct;
use App\Models\EntryProduct;
use App\Models\TakeContainer;
use App\Models\EntryContainer;
use App\Models\SuccessOrders;
use App\Models\ActiveTraffic;
use App\Models\TgToken;
use App\Models\ClientChat;
use App\Models\Traffic;
use App\Models\Product;
use App\Models\User;
use App\Models\Sity;
use App\Models\Area;
use App\Models\Sms;
use App\Models\SmsText;
use Auth;

class ClientController extends Controller
{
    public function view_location($id)
    {
        $client = Client::find($id);
        $locations[0] = $client->fullname;

        $arr = explode(',', $client->location);

        $locations[1] = $arr[0];
        $locations[2] = $arr[1];
        $locations[3] = 1;

        return view('clients.viewlocation', [
            'locations' => $locations
        ]);
    }

    public function client_price(Request $request, $id)
    {
        $clientprice = new ClientPrices();
        $clientprice->organization_id = auth()->user()->organization_id;
        $clientprice->success_order_id = 0;
        $clientprice->client_id = $id;
        $clientprice->user_id = Auth::user()->id;
        $clientprice->payment = $request->payment;
        $clientprice->amount = $request->amount;
        $clientprice->comment = $request->comment ?? '';
        $clientprice->status = 1;
        $clientprice->save();

        $client = Client::find($id);
        $client->balance = $client->balance + $request->amount;
        $client->save();

        return redirect()->back()->with('success', __('messages.price_added_successfully'));
    }

    public function client_price_edit(Request $request, $id)
    {
        try {

            $clientprice = ClientPrices::find($id);
            if ($clientprice->status == 1) {
                $price = $clientprice->amount;
                $clientprice->payment = $request->payment;
                $clientprice->amount = $request->amount;
                $clientprice->comment = $request->comment ?? '';
                $clientprice->save();

                $client = Client::find($clientprice->client_id);
                $client->balance = $client->balance - $price + $request->amount;
                $client->save();
            } else {
                $price = $clientprice->amount;
                $clientprice->payment = $request->payment;
                $clientprice->amount = $request->amount;
                $clientprice->comment = $request->comment ?? '';
                $clientprice->save();

                $client = Client::find($clientprice->client_id);
                $client->balance = $client->balance - $price + $request->amount;
                $client->save();

                $succ = SuccessOrders::find($clientprice->success_order_id);
                $succ->amount = $request->amount;
                $succ->price_sold = $request->amount - ($succ->count * $succ->price);
                $succ->save();
            }

            return redirect()->back()->with('success', __('messages.amount_receipts_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function client_price_delete($id)
    {
        try {

            $clientprice = ClientPrices::find($id);
            $price = $clientprice->amount;

            $client = Client::find($clientprice->client_id);
            $client->balance = $client->balance - $price;
            $client->save();
            $clientprice->delete();

            return redirect()->back()->with('success', __('messages.amount_receipts_deleted_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function client_container(Request $request, $id)
    {
        $clientprice = new ClientContainer();
        $clientprice->organization_id = auth()->user()->organization_id;
        $clientprice->success_order_id = 0;
        $clientprice->client_id = $id;
        $clientprice->user_id = Auth::user()->id;
        $clientprice->product_id = $request->product_id;
        $clientprice->count = $request->count;
        $clientprice->invalid_count = $request->invalid_count;
        $clientprice->comment = $request->comment ?? '';
        $clientprice->status = 1;
        $clientprice->save();

        $client = Client::find($id);
        $client->container = $client->container + $request->count - $request->invalid_count;
        $client->save();

        return redirect()->back()->with('success', __('messages.container_returned_successfully'));
    }

    public function client_container_edit(Request $request, $id)
    {
        try {

            $clientprice = ClientContainer::find($id);
            if ($clientprice->status == 1) {
                $count = $clientprice->count;
                $incount = $clientprice->invalid_count;

                $clientprice->product_id = $request->product_id;
                $clientprice->count = $request->count;
                $clientprice->invalid_count = $request->invalid_count;
                $clientprice->comment = $request->comment ?? '';
                $clientprice->save();

                $client = Client::find($clientprice->client_id);
                $client->container = $client->container - ($count - $incount) + $request->count - $request->invalid_count;
                $client->save();
            } else {
                $count = $clientprice->count;
                $incount = $clientprice->invalid_count;

                $clientprice->product_id = $request->product_id;
                $clientprice->count = $request->count;
                $clientprice->invalid_count = $request->invalid_count;
                $clientprice->comment = $request->comment ?? '';
                $clientprice->save();

                $client = Client::find($clientprice->client_id);
                $client->container = $client->container - ($count - $incount) + $request->count - $request->invalid_count;
                $client->save();

                $succ = SuccessOrders::find($clientprice->success_order_id);
                $succ->container = $request->count;
                $succ->invalid_container_count = $request->invalid_count;
                $succ->save();
            }

            return redirect()->back()->with('success', __('messages.returned_containers_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }
    public function client_container_delete($id)
    {
        try {

            $clientprice = ClientContainer::find($id);
            $count = $clientprice->count;
            $incount = $clientprice->invalid_count;

            $client = Client::find($clientprice->client_id);
            $client->container = $client->container - ($count - $incount);
            $client->save();

            $clientprice->delete();

            return redirect()->back()->with('success', __('messages.returned_containers_deleted_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function success_order_view($id)
    {
        $order = Order::find($id);
        $summ = $order->product_count * $order->price;
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        return view('clients.success_order', [
            'order' => $order,
            'summ' => $summ,
            'info_org' => $info_org
        ]);
    }

    public function take_products()
    {
        $info_id = auth()->user()->organization_id;
        $takeproducts = TakeProduct::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('received')->with('sent')->with('product');

        $products = Product::where('organization_id', $info_id)->get();

        $arr = UserOrganization::where('organization_id', $info_id)->pluck('user_id')->toArray();

        $users = User::whereIn('id', $arr)->get();

        $info_org = Organization::find($info_id);


        return view('sklad.take-product', [
            'takeproducts' => $takeproducts->paginate(10),
            'products' => $products,
            'users' => $users,
            'info_org' => $info_org
        ]);
    }

    public function entry_products()
    {
        $info_id = auth()->user()->organization_id;

        $users = User::where('organization_id', $info_id)->get();

        $entryproduct = EntryProduct::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('user')->with('product');

        $takeproducts = TakeProduct::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('received')->with('sent')->with('product');

        $entrycontainer = EntryContainer::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->with('received')
            ->with('product');

        $takecontainer = TakeContainer::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->with('product');

        $products = Product::where('organization_id', $info_id)->get();


        return view('sklad.entry-product', [
            'entryproduct' => $entryproduct->paginate(10),
            'products' => $products,
            'users' => $users,
            'takeproducts' => $takeproducts->paginate(10),
            'entrycontainer' => $entrycontainer->paginate(10),
            'takecontainer' => $takecontainer->paginate(10)
        ]);
    }

    public function entry_container()
    {
        $info_id = auth()->user()->organization_id;
        $entrycontainer = EntryContainer::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->with('received')
            ->with('product');

        $products = Product::where('organization_id', $info_id)->get();

        $arr = UserOrganization::where('organization_id', $info_id)->pluck('user_id')->toArray();

        $users = User::whereIn('id', $arr)->get();

        $info_org = Organization::find($info_id);

        return view('sklad.entry-container', [
            'entrycontainer' => $entrycontainer->paginate(10),
            'products' => $products,
            'users' => $users,
            'info_org' => $info_org
        ]);
    }

    public function take_container()
    {
        $info_id = auth()->user()->organization_id;

        $takecontainer = TakeContainer::where('organization_id', $info_id)
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->with('product');

        $products = Product::where('organization_id', $info_id)->get();

        $info_org = Organization::find($info_id);

        return view('sklad.take-container', [
            'takecontainer' => $takecontainer->paginate(10),
            'products' => $products,
            'info_org' => $info_org
        ]);
    }

    public function add_take_product(Request $request)
    {
        try {

            $organ = auth()->user()->organization_id;

            $takproduct = new TakeProduct();
            $takproduct->organization_id = $organ;
            $takproduct->received_id = $request->user_id;
            $takproduct->sent_id = Auth::user()->id;
            $takproduct->product_id = $request->product_id;
            $takproduct->product_count = $request->product_count;
            $takproduct->save();

            $prod = Product::find($request->product_id);
            $prod->product_count = $prod->product_count - $request->product_count;
            $prod->save();

            return redirect()->back()->with('success', __('messages.product_taked_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function take_edit_product(Request $request, $id)
    {

        try {

            $takproduct = TakeProduct::find($id);
            $takproduct->received_id = $request->user_id;
            $takproduct->sent_id = Auth::user()->id;
            $takproduct->product_id = $request->product_id;
            $old = $takproduct->product_count;
            $takproduct->product_count = $request->product_count;
            $takproduct->save();

            $prod = Product::find($request->product_id);
            $prod->product_count = $prod->product_count + $old - $request->product_count;
            $prod->save();


            return redirect()->back()->with('success', __('messages.taked_product_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function take_delete_product()
    {
        try {

            $takproduct = TakeProduct::find(request('id'));
            $old = $takproduct->product_count;
            $oldid = $takproduct->product_id;

            $prod = Product::find($oldid);
            $prod->product_count = $prod->product_count + $old;
            $prod->save();
            $takproduct->delete();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function add_entry_product(Request $request)
    {
        try {

            $organ = auth()->user()->organization_id;

            $entryproduct = new EntryProduct();
            $entryproduct->organization_id = $organ;
            $entryproduct->product_id = $request->product_id;
            $entryproduct->user_id = Auth::user()->id;
            $entryproduct->product_count = $request->product_count;
            $entryproduct->price = $request->price;
            $entryproduct->comment = $request->comment ?? '';
            $entryproduct->save();

            $prod = Product::find($request->product_id);
            $prod->product_count = $prod->product_count + $request->product_count;
            $prod->save();

            return redirect()->back()->with('success', __('messages.product_entered_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit_entry_product(Request $request, $id)
    {
        try {

            $entryproduct = EntryProduct::find($id);

            $entryproduct->product_id = $request->product_id;
            $entryproduct->user_id = Auth::user()->id;
            $old = $entryproduct->product_count;
            $entryproduct->product_count = $request->product_count;
            $entryproduct->price = $request->price;
            $entryproduct->comment = $request->comment ?? '';
            $entryproduct->save();

            $prod = Product::find($request->product_id);
            $prod->product_count = $prod->product_count - $old + $request->product_count;
            $prod->save();

            return redirect()->back()->with('success', __('messages.product_entered_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function delete_entry_product()
    {
        try {

            $entryproduct = EntryProduct::find(request('id'));
            $old = $entryproduct->product_count;
            $oldid = $entryproduct->product_id;

            $entryproduct->delete();

            $prod = Product::find($oldid);
            $prod->product_count = $prod->product_count - $old;
            $prod->save();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function add_entry_container(Request $request)
    {
        try {

            $organ = auth()->user()->organization_id;

            $entrycontainer = new EntryContainer();
            $entrycontainer->organization_id = $organ;
            $entrycontainer->product_id = $request->product_id;
            $entrycontainer->user_id = $request->user_id;
            $entrycontainer->product_count = $request->container_count;
            $entrycontainer->received_id = Auth::user()->id;
            $entrycontainer->save();

            $prod = Product::find($request->product_id);
            $prod->container = $prod->container + $request->container_count;
            $prod->save();

            return redirect()->back()->with('success', __('messages.entry_container_added_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function edit_entry_container(Request $request, $id)
    {

        try {

            $entrycontainer = EntryContainer::find($id);
            $old = $entrycontainer->product_count;

            $entrycontainer->product_id = $request->product_id;
            $entrycontainer->user_id = $request->user_id;
            $entrycontainer->product_count = $request->container_count;
            $entrycontainer->received_id = Auth::user()->id;
            $entrycontainer->save();

            $prod = Product::find($request->product_id);
            $prod->container = $prod->container - $old + $request->container_count;
            $prod->save();

            return redirect()->back()->with('success', __('messages.entry_container_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function delete_entry_container()
    {

        try {

            $entrycontainer = EntryContainer::find(request('id'));
            $prodid = $entrycontainer->product_id;
            $old = $entrycontainer->product_count;

            $prod = Product::find($prodid);
            $prod->container = $prod->container - $old;
            $prod->save();
            $entrycontainer->delete();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function edit_product(Request $request, $id)
    {

        try {

            if ($request->photo != null) {
                $fileName = time() . '.' . $request->photo->extension();
                $path = $request->photo->storeAs('products', $fileName);
            }

            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->container_status = $request->container_status;

            if ($request->photo != null) {
                $product->photo = 'storage/products/' . $fileName;
            } else
                $product->photo = '';

            $product->save();

            return redirect()->back()->with('success', __('messages.product_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_product()
    {

        try {

            Product::find(request('id'))->delete();

            return response()->json([
                'message' => __('messages.product_deleted_successfully')
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function take_entry_container(Request $request)
    {
        try {

            $organ = auth()->user()->organization_id;

            $entrycontainer = new TakeContainer();
            $entrycontainer->organization_id = $organ;
            $entrycontainer->user_id = Auth::user()->id;
            $entrycontainer->product_id = $request->product_id;
            $entrycontainer->product_count = $request->product_count;
            $entrycontainer->comment = $request->comment ?? '';
            $entrycontainer->save();

            $prod = Product::find($request->product_id);
            $prod->container = $prod->container - $request->product_count;
            $prod->save();

            return redirect()->back()->with('success', __('messages.take_container_addedd_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function take_edit_container(Request $request, $id)
    {
        try {

            $entrycontainer = TakeContainer::find($id);
            $entrycontainer->user_id = Auth::user()->id;
            $entrycontainer->product_id = $request->product_id;
            $old = $entrycontainer->product_count;

            $entrycontainer->product_count = $request->product_count;
            $entrycontainer->comment = $request->comment ?? '';
            $entrycontainer->save();

            $prod = Product::find($request->product_id);
            $prod->container = $prod->container - $request->product_count + $old;
            $prod->save();

            return redirect()->back()->with('success', __('messages.take_container_updated_successfully'));

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function take_delete_container()
    {
        try {

            $entrycontainer = TakeContainer::find(request('id'));
            $old = $entrycontainer->product_count;
            $oldid = $entrycontainer->product_id;

            $prod = Product::find($oldid);
            $prod->container = $prod->container + $old;
            $prod->save();
            $entrycontainer->delete();

            return response()->json([
                'message' => __('messages.product_deleted_successfully')
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function send_message(Request $request)
    {
        $organ = auth()->user()->organization_id;
        $clients = Client::query()
            ->where('organization_id', $organ)
            ->when(request('city_id'), function ($query, $city_id) {
                return $query->where('city_id', $city_id);
            })
            ->when(request('area_id'), function ($query, $area_id) {
                return $query->where('area_id', $area_id);
            })
            ->with('city')
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->with('area');

        $sities = Sity::where('organization_id', $organ)->get();
        $areas = Area::where('city_id', request('city_id', 0))->get();

        $products = Product::where('organization_id', $organ)->get();
        $info_org = Organization::find($organ);
        $client_count = $clients->count();
        if (!$request->paginate)
            $paginate = 10;
        else
            $paginate = $request->paginate;
        return view('smsmanager.sendmessage', [
            'clients' => $clients->paginate($paginate),
            'sities' => $sities,
            'areas' => $areas,
            'products' => $products,
            'info_org' => $info_org,
            'client_count' => $client_count
        ]);
    }

    public function members(Request $request)
    {
        $organ = auth()->user()->organization_id;

        $clients = ClientChat::query()
            ->whereHas('client', function ($q) use ($organ) {
                $q->where('organization_id', $organ);
            })
            ->when(request('city_id'), function ($query, $city_id) {
                $query->whereHas('client', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                });
            })
            ->when(request('area_id'), function ($query, $area_id) {
                $query->whereHas('client', function ($q) use ($area_id) {
                    $q->where('area_id', $area_id);
                });
            })
            ->when(request('search'), function ($query, $search) {
                $query->whereHas('client', function ($q) use ($search) {
                    $q->where('fullname', 'LIKE', '%' . $search . '%');
                });
            })
            ->with(['client']);

        $sities = Sity::where('organization_id', $organ)->get();
        $areas = Area::where('city_id', request('city_id', 0))->get();

        return view('smsmanager.tg_send_message', [
            'clients' => $clients->paginate(request('per_page', 10)),
            'sities' => $sities,
            'areas' => $areas
        ]);
    }

    public function sms_text()
    {
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        $smsText = SmsText::where('organization_id', $info_id)->first();

        return view('smsmanager.smstext', [
            'info_org' => $info_org,
            'smsText' => $smsText
        ]);
    }

    public function success_message()
    {
        $organ = auth()->user()->organization_id;

        $smsmanagers = Sms::query()
            ->where('organization_id', $organ)

            ->when(request('search'), function ($query, $search) {
                return $query->whereHas(
                    'client',
                    function ($q) use ($search) {
                        $q->where('fullname', 'LIKE', '%' . $search . '%');
                    }
                );
            })
            ->when(request('data'), function ($query, $data) {
                return $query->whereDate('created_at', $data);
            })
            ->orderBy('created_at', 'DESC')
            ->with('client')
            ->with('user');

        return view('smsmanager.successmessage', [
            'smsmanagers' => $smsmanagers->paginate(request('per_page', 10))
        ]);
    }


    public function send_client_message($text, $phone_number, $id)
    {

        $char = ['(', ')', ' ', '-', '+'];
        $replace = ['', '', '', '', ''];
        $phone = str_replace($char, $replace, $phone_number);

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://sms.etc.uz:8084/json2sms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => "{
                   \"login\":\"sms0085ts\",
                   \"pwd\":\"01986max\",
                   \"CgPN\":\"WEBEST_UZ\",
                   \"CdPN\":\"998$phone\",
                   \"text\":\"$text\"
               }",
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);

        $json = json_decode($response, true);

        if ($json['query_state'] == "SUCCESS") {

            $organ = auth()->user()->organization_id;
            $count = Organization::find($organ);
            $count->sms_count = $count->sms_count + 1;
            $count->save();

            $cl = Client::find($id);

            $sms = new Sms();
            $sms->organization_id = $organ;
            $sms->client_id = $id;
            $sms->user_id = Auth::user()->id;
            $sms->city_id = $cl->city_id;
            $sms->area_id = $cl->area_id;
            $sms->fullname = $cl->fullname;
            $sms->phone = $cl->phone;
            $sms->sms_text = $text;
            $sms->save();
        }

        return 1;
    }


    public function send_sms(Request $request)
    {
        $organ = auth()->user()->organization_id;
        $count = Organization::find($organ);

        if ($count->sms_count < $count->traffic->sms_count + $count->location) {

            $arr = $request->checkbox;
            $x = 0;

            foreach ($arr as $key => $value) {

                $phone_number = Client::find($key)->phone;
                if ($this->send_client_message($request->text, $phone_number, $key) == 1)
                    $x++;

                $count = Organization::find($organ);
                if ($count->sms_count >= $count->traffic->sms_count)
                    break;
            }

            return redirect()->back()->with('msg', $x);

        } else

            return redirect()->back()->with('msg', 0);


    }

    public function client_profile(Request $request)
    {
        //dd($request->all());

        $error = '
        {
            "error" : "Unauthorized"
        }
        ';

        $client = Client::where('login', $request->login)->where('password', $request->password)->get();

        if (count($client))
            return $client;
        else
            return json_decode($error, true);
    }

    public function resultorders(Request $request)
    {
        $products = Product::where('organization_id', auth()->user()->organization_id)->get();

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {
            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $orders = Order::whereDate('created_at', '>=', $date1)
            ->when(request('product_id'), function ($query, $product_id) {
                $query->where('product_id', $product_id);
            })
            ->whereDate('created_at', '<=', $date2)
            ->where('organization_id', $info_id)
            ->where('user_id', request('id'))
            ->with('client')
            ->with('user')
            ->with('product')
            ->orderBy('updated_at', 'desc');

        $total = $orders->sum('product_count');

        return view('result.resultorders', [
            'orders' => $orders->paginate(10),
            'total' => $total,
            'products' => $products
        ]);

    }

    public function resulttakeproducts(Request $request)
    {
        $products = Product::where('organization_id', auth()->user()->organization_id)->get();

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $takeproducts = TakeProduct::whereDate('created_at', '>=', $date1)
            ->when(request('product_id'), function ($query, $product_id) {
                $query->where('product_id', $product_id);
            })
            ->whereDate('created_at', '<=', $date2)
            ->where('organization_id', $info_id)
            ->where('received_id', request('id'))
            ->with('received')
            ->with('sent')
            ->with('product')
            ->orderBy('updated_at', 'desc');

        $total = $takeproducts->sum('product_count');

        return view('result.resulttake', [
            'takeproducts' => $takeproducts->paginate(10),
            'total' => $total,
            'products' => $products
        ]);

    }

    public function resultsold(Request $request)
    {
        $products = Product::where('organization_id', auth()->user()->organization_id)->get();

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $soldproducts = SuccessOrders::where('organization_id', $info_id)
            ->when(request('product_id'), function ($query, $product_id) {
                $query->where('product_id', $product_id);
            })
            ->where('user_id', request('id'))
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->with('user')
            ->with('product')
            ->orderBy('updated_at', 'desc');

        $order_count_total = $soldproducts->sum('order_count');
        $order_price_total = $soldproducts->sum('order_price');
        $count_total = $soldproducts->sum('count');
        $price_total = $soldproducts->sum('price');
        $container_total = $soldproducts->sum('container');
        $amount_total = $soldproducts->sum('amount');

        return view('result.soldproduct', [
            'soldproducts' => $soldproducts->paginate(10),
            'order_count_total' => $order_count_total,
            'order_price_total' => $order_price_total,
            'count_total' => $count_total,
            'price_total' => $price_total,
            'container_total' => $container_total,
            'amount_total' => $amount_total,
            'products' => $products
        ]);
    }

    public function summresult(Request $request)
    {
        $products = Product::where('organization_id', auth()->user()->organization_id)->get();
        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $soldproducts = SuccessOrders::where('organization_id', $info_id)
            ->when(request('product_id'), function ($query, $product_id) {
                $query->where('product_id', $product_id);
            })
            ->where('user_id', request('id'))
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->with('user')
            ->with('product')
            ->orderBy('updated_at', 'desc');

        $order_count_total = $soldproducts->sum('order_count');
        $order_price_total = $soldproducts->sum('order_price');
        $count_total = $soldproducts->sum('count');
        $price_total = $soldproducts->sum('price');
        $container_total = $soldproducts->sum('container');
        $amount_total = $soldproducts->sum('amount');


        return view('result.summ', [
            'soldproducts' => $soldproducts->paginate(10),
            'order_count_total' => $order_count_total,
            'order_price_total' => $order_price_total,
            'count_total' => $count_total,
            'price_total' => $price_total,
            'container_total' => $container_total,
            'amount_total' => $amount_total,
            'products' => $products
        ]);
    }

    public function resultentrycontainer(Request $request)
    {

        $products = Product::where('organization_id', auth()->user()->organization_id)->get();

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $entrycontainer = SuccessOrders::whereDate('created_at', '>=', $date1)
            ->when(request('product_id'), function ($query, $product_id) {
                $query->where('product_id', $product_id);
            })
            ->whereDate('created_at', '<=', $date2)
            ->where('organization_id', $info_id)
            ->with('user')
            ->with('client')
            ->with('product')
            ->where('user_id', request('id'))
            ->orderBy('updated_at', 'desc');


        $summ_con = $entrycontainer->sum('container');
        $summ_con_in = $entrycontainer->sum('invalid_container_count');

        return view('result.resultentryontainer', [
            'entrycontainer' => $entrycontainer->paginate(10),
            'summ_con' => $summ_con,
            'summ_con_in' => $summ_con_in,
            'products' => $products,
        ]);
    }

    public function payment1(Request $request)
    {


        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $clientprices = ClientPrices::where('organization_id', $info_id)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->where('payment', 1)
            ->with('user')
            ->with('client')
            ->where('user_id', request('id'))
            ->orderBy('updated_at', 'desc');
        $total = $clientprices->sum('amount');

        return view('result.payment1', [
            'clientprices' => $clientprices->paginate(10),
            'total' => $total
        ]);
    }
    public function payment2(Request $request)
    {

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $clientprices = ClientPrices::where('organization_id', $info_id)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->where('payment', 2)
            ->with('user')
            ->with('client')
            ->where('user_id', request('id'))
            ->orderBy('updated_at', 'desc');

        $total = $clientprices->sum('amount');

        return view('result.payment2', [
            'clientprices' => $clientprices->paginate(10),
            'total' => $total
        ]);
    }

    public function payment3(Request $request)
    {

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $clientprices = ClientPrices::where('organization_id', $info_id)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->where('payment', 3)
            ->with('user')
            ->with('client')
            ->where('user_id', request('id'))
            ->orderBy('updated_at', 'desc');

        $total = $clientprices->sum('amount');

        return view('result.payment3', [
            'clientprices' => $clientprices->paginate(10),
            'total' => $total
        ]);
    }

    public function dolgresult(Request $request)
    {

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $info_id = auth()->user()->organization_id;

        $soldproducts = SuccessOrders::where('organization_id', $info_id)->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->where('price_sold', '<', 0)
            ->whereIn('order_status', [1, 2])
            ->where('user_id', request('id'));


        $order_count_total = $soldproducts->sum('order_count');
        $count_total = $soldproducts->sum('count');
        $amount_total = $soldproducts->sum('amount');
        $price_sold = $soldproducts->sum('price_sold');

        return view('result.dolg', [
            'soldproducts' => $soldproducts->paginate(10),
            'order_count_total' => $order_count_total,
            'count_total' => $count_total,
            'amount_total' => $amount_total,
            'price_sold' => $price_sold
        ]);
    }

    public function admin_traffics()
    {

        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);
        $traffics = Traffic::whereIn('id', explode(',', ActiveTraffic::find(1)->string1))->get();

        return view('clients.traffics', [
            'info_org' => $info_org,
            'traffics' => $traffics
        ]);
    }

    public function dolgs()
    {

        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        $clients = Client::where('organization_id', $info_id)
            ->where(function ($query) {
                $query->where('balance', '<', 0)
                    ->orWhere('container', '<', 0);
            })->orderBy('balance', 'ASC');

        return view('but_results.dolg', [
            'info_org' => $info_org,
            'clients' => $clients->paginate(10)
        ]);
    }

    public function client_products(Request $request)
    {
        $org_id = Client::find($request->client_id)->organization_id;
        $products = Product::where('organization_id', $org_id)->get();

        return response()->json($products, 200);
    }

    public function client_add_order(Request $request)
    {
        $order = Order::where('client_id', $request->client_id)
            ->where('product_id', $request->product_id)
            ->where('status', 0)
            ->count();

        if ($order > 0) {
            return response()->json([
                'message' => 'Sizda ushbu tovardan tugallanmagan zakaz mavjud!'
            ], 422);
        }

        $client = Client::find($request->client_id);
        $product = Product::findOrFail($request->product_id);

        $zakaz = new Order();
        $zakaz->organization_id = $client->organization_id;
        $zakaz->city_id = $client->city_id;
        $zakaz->area_id = $client->area_id;
        $zakaz->client_id = $request->client_id;
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = $product->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $product->price;
        $zakaz->comment = 'Mijoz mobil ilova orqali';
        $zakaz->status = 0;
        $zakaz->user_id = $client->user_id;
        $zakaz->save();

        $orders = Order::where('client_id', $request->client_id)->get();

        return response()->json($orders, 200);
    }

    public function client_add_order_telegram(Request $request)
    {
        $order = Order::where('client_id', $request->client_id)
            ->where('product_id', $request->product_id)
            ->where('status', 0)
            ->count();

        if ($order > 0) {
            return response()->json([
                'message' => 'Sizda ushbu tovardan tugallanmagan zakaz mavjud!'
            ], 422);
        }

        $client = Client::find($request->client_id);
        $product = Product::findOrFail($request->product_id);

        $zakaz = new Order();
        $zakaz->organization_id = $client->organization_id;
        $zakaz->city_id = $client->city_id;
        $zakaz->area_id = $client->area_id;
        $zakaz->client_id = $request->client_id;
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = $product->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $product->price;
        $zakaz->comment = 'Mijoz telegram orqali';
        $zakaz->status = 0;
        $zakaz->user_id = $client->user_id;
        $zakaz->save();

        $orders = Order::where('client_id', $request->client_id)->get();

        return response()->json($orders, 200);
    }

    public function client_order(Request $request)
    {
        $orders = Order::
            where('client_id', $request->client_id)
            ->where('status', 0)
            ->with('product')->get();

        return response()->json($orders, 200);
    }

    public function client_order_edit(Request $request)
    {

        $product = Product::find($request->product_id);

        $zakaz = Order::find($request->order_id);
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = $product->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $product->price;
        $zakaz->comment = 'Mijoz mobil ilova orqali taxrirladi';
        $zakaz->save();

        return response()->json(['message' => 'Zakaz muvaffaqqiyatli taxrirlandi!'], 200);
    }

    public function client_order_edit_telegram(Request $request)
    {

        $product = Product::find($request->product_id);

        $zakaz = Order::find($request->order_id);
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = $product->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $product->price;
        $zakaz->comment = 'Mijoz telegram orqali taxrirladi';
        $zakaz->save();

        return response()->json(['message' => 'Zakaz muvaffaqqiyatli taxrirlandi!'], 200);
    }

    public function client_order_delete(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 1;
        $order->comment = "Mijoz mobil ilova orqali o'chirdi";
        $order->save();

        return response()->json(['message' => 'Zakaz muvaffaqqiyatli ochirildi!'], 200);
    }

    public function client_order_delete_telegram(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 1;
        $order->comment = "Mijoz telegram orqali o'chirdi";
        $order->save();

        return response()->json(['message' => 'Zakaz muvaffaqqiyatli ochirildi!'], 200);
    }

    public function cl_succ_orders(Request $request)
    {
        $orders = SuccessOrders::
            where('client_id', $request->client_id)
            ->whereIn('order_status', [1, 2])
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders, 200);
    }

    public function client_info(Request $request)
    {
        $client = Client::where('id', $request->client_id)->with('organization')->get();

        return response()->json($client[0], 200);
    }

    public function sms_text_new(Request $request)
    {
        if (!$request->a) {
            return response()->json([
                'message' => "Text ko'rinishini kiriting!"
            ], 400);
        } else {
            $txt = $request->a;
            $arr = explode('&', $txt);

            $org_id = auth()->user()->organization_id;
            SmsText::where('organization_id', $org_id)->delete();

            foreach ($arr as $key => $value) {
                if ($value != null || $value != '')

                    SmsText::create([
                        'organization_id' => $org_id,
                        'sms_text' => $value,
                        'full_sms_text' => $request->b
                    ]);
            }
            return response()->json([
                'message' => "Muvaffaqqiyatli qo'shildi!"
            ]);
        }

    }

    public function bot_token(Request $request)
    {

        $tokens = TgToken::get()->count();
        if ($tokens == 0) {
            $message = new TgToken();
            $message->res_token = $request->token;
            $message->save();

            return response()->json([
                'message' => "success"
            ]);

        } else {
            $message = TgToken::find(1);
            $message->res_token = $request->token;
            $message->save();

            return response()->json([
                'message' => "success"
            ]);
        }

        return response()->json([
            'message' => "success"
        ]);
    }

    public function registration($client_id, Request $request)
    {
        $client = Client::where('id', $client_id)->first();
        if ($client) {
            $newinfo = new ClientChat();
            $newinfo->client_id = $client_id;
            $newinfo->name = $request->fullname;
            $newinfo->phone = $request->phone;
            $newinfo->chat_id = $request->chat_id;
            $newinfo->save();


            return response()->json([
                'message' => "success"
            ]);
        } else
            return response()->json([
                'message' => "Bunday foydalanuvchi topilmadi!"
            ], 404);

    }

    public function logout_client($client_id)
    {

        $newinfo = ClientChat::where('client_id', $client_id)->delete();

        return response()->json([
            'message' => "success"
        ]);
    }

}