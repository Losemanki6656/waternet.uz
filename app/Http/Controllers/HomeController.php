<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Sity;
use App\Models\Organization;
use App\Models\UserOrganization;
use App\Models\Product;
use App\Models\Order;
use App\Models\SuccessOrders;
use App\Models\ClientPrices;
use App\Models\ClientContainer;
use App\Models\Area;
use App\Models\OrderArchive;
use App\Models\User;
use App\Models\RegionUser;
use App\Models\TakeProduct;
use App\Models\EntryProduct;
use App\Models\Sms;
use App\Models\EntryContainer;
use App\Models\ActiveTraffic;
use Illuminate\Support\Facades\Validator;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        if(Auth::user()->id != 1)
        if($info_org->date_traffic < now()) 
        return view('error');

        return view('home',[
            'info_org' => $info_org
        ]); 
    }

    public function statistics()
    {
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        if($info_org->date_traffic < now()) 
        return view('error');

        if(Auth::user()->id != 1)
        {

            $solds = SuccessOrders::whereDate('created_at', now())
            ->where('organization_id',$info_id)
            ->whereIn('order_status',[1,2])->get();
            $solds2 = ClientPrices::whereDate('created_at',now())
            ->where('organization_id',$info_id)
            ->where('status',1)->get();

            $soldsumm = 0; 
            $payment1 = 0; 
            $payment2 = 0;

            foreach ($solds as $sold) {

                if($sold->count * $sold->price >= $sold->amount)
                    $soldsumm = $soldsumm + $sold->count * $sold->price;
                else
                $soldsumm = $soldsumm + $sold->amount;
                
                if($sold->payment == 1) $payment1 = $payment1 + $sold->amount;
                if($sold->payment == 2) $payment2 = $payment2 + $sold->amount;
            }

            foreach ($solds2 as $sold) {
                $soldsumm = $soldsumm + $sold->amount;

                if($sold->payment == 1) $payment1 = $payment1 + $sold->amount;
                if($sold->payment == 2) $payment2 = $payment2 + $sold->amount;
            }

            $x = $payment1+$payment2;

            $dolg = Client::where('organization_id',$info_id)->where('balance','<','0')->sum('balance');
            $pered = Client::where('organization_id',$info_id)->where('balance','>','0')->sum('balance');
            $clients = Client::where('organization_id',$info_id)->get()->count();
            $lastclients = Client::where('organization_id',$info_id)->whereMonth('created_at', \Carbon\Carbon::now()->month)->get()->count();
            
            return view('statistics',[
                'info_org' => $info_org,
                'dolg' => $dolg,
                'pered' => $pered,
                'soldsumm' => $soldsumm,
                'x' => $x,
                'clients' => $clients,
                'lastclients' => $lastclients
            ]);     
        }
        else
            return redirect()->route('organizations');
    }

    public function active_traffics(Request $request)
    {
        $i = 0; $a= [];
        if($request->tras)
        foreach($request->tras as $key => $value) {
            $i ++;
            $a[$i] = $key;
        }
        if($request->tras2)
        foreach($request->tras2 as $key => $value) {
            $i ++;
            $a[$i] = $key;
        }
        $x = ActiveTraffic::find(1);
        $x->string1 = implode(',',$a);
        $x->save();   
        
        return redirect()->back()->with('msg' ,'ertraf');
    }
    
    public function clients()
    {

        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $clients = Client::query()
        ->where('organization_id', $organ)
        ->when(\Request::input('search'),function($query,$search){
            $query->where(function ($query) use ($search) {
                $query->Orwhere('fullname','like','%'.$search.'%')
                    ->orWhere('phone','like','%'.$search.'%')
                    ->orWhere('address','like','%'.$search.'%');
            });
        })
        ->when(request('city_id'), function ($query, $city_id) {
            return $query->where('city_id', $city_id);
        })
        ->when(request('area_id'), function ($query, $area_id) {
            return $query->where('area_id', $area_id);
        })->orderBy('activated_at', 'DESC');

        $sities = Sity::where('organization_id',$organ)->get();
        $areas = Area::where('city_id', request('city_id', 0))->get();
        $ars = Area::where('organization_id', $organ)->get();

        $products = Product::where('organization_id', $organ)->get();
        $info_id = $organ;
        $info_org = Organization::find($info_id);
        //dd($organ);
        if($info_org->date_traffic < now()) 
        return view('error');

        $page = request('page', session('clients_page', 1));
        session(['clients_page' => $page]);

        return view('clients.clients',[
            'clients' => $clients->paginate(10, ['*'], 'page', $page),
            'sities' => $sities,
            'areas' => $areas,
            'products' => $products,
            'info_org' => $info_org,
            'ars'   => $ars
        ]);
    }

    public function add_client_page()
    {
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $count = Organization::find($organ);

        if($count->clients_count < $count->traffic->clients_count) { 
            $clients = Client::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('city')->with('user')->get();
            
            $sities = Sity::where('organization_id',$organ)->get();
            $areas = Area::where('city_id', request('city_id', 0))->get();
            
            $info_org = Organization::find($organ);
    
            return view('clients.addclient',[
                'clients' => $clients,
                'sities' => $sities,
                'areas' => $areas,
                'info_org' => $info_org
            ]);
        } else return redirect()->back()->with('msg' ,'ertraf');

        
    }

    public function location()
    {
        return view('clients.location');
    }
    public function location_id($id)
    {
        return view('clients.location_id',[
            'id_client' => $id
        ]);
    }

    public function add_client(Request $request)
    {

        $validated = $request->validate([
            'login' => 'required|unique:clients|max:255'
        ]);
        
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $client = new Client();
        $client->organization_id = $organ;
        $client->user_id = Auth::user()->id;
        $client->fullname = $request->fullname;
        $client->city_id = $request->sity_id;
        $client->area_id = $request->area_id;
        $client->street =  $request->ulitsa?? ' ';
        $client->home_number =  $request->home_number?? ' ';
        $client->entrance = $request->podezd?? ' ';
        $client->floor = $request->etaj?? ' ';
        $client->apartment_number = $request->kv_number?? ' ';
        $client->address = $request->address ?? '';
        $client->bonus = $request->bonus?? '0';
        $client->balance = "0";
        $client->container = 0;
        $client->login = $request->login;
        $client->password = $request->password;
        $client->location = $request->location;
        $client->activated_at = now();
        $client->phone = $request->phone1;
        $client->phone2 = $request->phone2 ?? '';
        $client->save();

        $count = Organization::find($organ);
        $count->clients_count = $count->clients_count + 1;
        $count->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function client_edit(Request $request, $id)
    {

        $client = Client::find($id);
        $client->fullname = $request->fullname;
        $client->city_id = $request->city_id;
        $client->area_id = $request->area_id;
        $client->street =  $request->street?? ' ';
        $client->home_number =  $request->home_number?? ' ';
        $client->entrance = $request->entrance?? ' ';
        $client->floor = $request->floor?? ' ';
        $client->apartment_number = $request->apartment_number?? ' ';
        $client->address = $request->address ?? '';
        $client->login = $request->login;
        $client->password = $request->password;
        $client->location = $request->location;
        $client->phone = $request->phone;
        $client->phone2 = $request->phone2 ?? '';
    
        $client->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_client($id)
    {

        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $client = Client::find($id)->delete();

        $count = Organization::find($organ);
        $count->clients_count = $count->clients_count - 1;
        $count->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function add_location(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->location = $request->lat.",".$request->lng;
        $client->save();

        return response()->json(['message' => 'success']);
    }

    public function add_order(Request $request, $id)
    {
        $order = Order::where('client_id',$id)->where('product_id',$request->product_id)->where('status',0)->get();
        $client = Client::find($id);
        if($order->count() > 0) {
            return redirect()->route('client_order_edit' , [ 'id' => $id ]);
        }

        $zakaz = new Order();
        $zakaz->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $zakaz->city_id = $client->city_id;
        $zakaz->area_id = $client->area_id;
        $zakaz->client_id = $id;
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = Product::findOrFail($request->product_id)->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $request->sena;
        $zakaz->comment = $request->izoh ?? '';
        $zakaz->status = 0;
        $zakaz->user_id = Auth::user()->id;
        $zakaz->save();

        $client = Client::find($id);
        $client->activated_at = now();
        $client->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function add_region(Request $request)
    {
        $sity = new Sity();
        $sity->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $sity->name = $request->region_name;
        $sity->save();

        return redirect()->back()->with('msg' ,'succ_region');
    }
    public function add_city(Request $request)
    {
        $sity = new Area();
        $sity->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $sity->city_id = $request->sity_id;
        $sity->name = $request->area_name;
        $sity->save();

        return redirect()->back()->with('msg' ,'succ_city');
    }

    public function orders()
    {
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $orders = Order::query()
        ->where('status',0)
        ->where('organization_id', $organ)
        ->has('client')->with('user')->with('product')
        
        ->when(\Request::input('search'),function($query,$search){
            $query->whereHas('client',function ($query) use ($search) {
                $query->where('fullname','like','%'.$search.'%')
                    ->Orwhere('phone','like','%'.$search.'%')
                    ->Orwhere('address','like','%'.$search.'%');
            });
        })

        ->when(request('city_id'), function ($query, $city_id) {
            return $query->where('city_id', $city_id);
        })
        ->when(request('area_id'), function ($query, $area_id) {
            return $query->where('area_id', $area_id);
        });

        $sities = Sity::where('organization_id', $organ)->get();
        $areas = Area::where('city_id', request('city_id', 0))->get();
        
        $info_org = Organization::find($organ);

        if($info_org->date_traffic < now()) 
        return view('error');

        return view('clients.orders',[
            'orders' => $orders->paginate(10),
            'sities' => $sities,
            'areas'  => $areas,
            'info_org' => $info_org
        ]);
    }

    public function client_order_edit($id)
    {
      
        $orders = Order::where('client_id', $id)->where('status',0)->with('client')->with('user')->with('product')->get();
  
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);
        
        $products = Product::where('organization_id', $info_id)->get();

        return view('clients.order_edit',[
            'orders' => $orders,
            'info_org' => $info_org,
            'products' => $products
        ]);
    }

    public function order_edit(Request $request, $id)
    {
        $zakaz = Order::find($id);
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = Product::findOrFail($request->product_id)->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $request->sena;
        $zakaz->comment = $request->izoh ?? '';
        $zakaz->save();

        return redirect()->back()->with('msg' ,'success');
     
    }


    public function soldproducts($id)
    {
        $client = Client::find($id);
        $soldproducts = SuccessOrders::where('client_id',$id)->get();
        $clientprices = ClientPrices::where('client_id',$id)->get();
        $clientcontainer = ClientContainer::where('client_id',$id)->get();
        $products = Product::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        //dd($clientprices->count());
        $summ = 0;
        foreach ($soldproducts as $sold){
            $summ = $summ + $sold->amount;
        }
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('clients.soldproducts',[
            'client' => $client,
            'soldproducts' => $soldproducts,
            'summ' => $summ,
            'clientprices' => $clientprices,
            'clientcontainer' => $clientcontainer,
            'products' => $products,
            'info_org' => $info_org
        ]);
    }
    
    public function success_order_api(Request $request) {
      
        $id = $request->order_id;
       
        $orderinfo = Order::find($id);

        $client_info = Client::find($orderinfo->client_id);
        
        $x = $orderinfo->client_id;
        
        $y = $client_info->balance;

        if(SuccessOrders::where('created_at',now())->where('client_id',$orderinfo->client_id)->get()->count() > 0) 
            return response()->json(['message' => 'error', 429 ]);
            else {
                if ($request->order_status == 1 || $request->order_status == 2 ) {

                    $client_info->balance = $client_info->balance  - ($request->sold_product_count * $request->sold_product_price) + $request->amount;
               
                    if(Product::find($orderinfo->product_id)->container_status != 1)
                        $client_info->container = $client_info->container - $request->sold_product_count + $request->container - $request->invalid_container_count;
                    
                    $client_info->save();
                }
        
                $successorder = new SuccessOrders();
                $successorder->organization_id = $orderinfo->organization_id;
                $successorder->client_id = $orderinfo->client_id;
                $successorder->product_id = $orderinfo->product_id;
                $successorder->user_id = Auth::user()->id;
                $successorder->order_user_id = $orderinfo->user_id;
                $successorder->order_status = $request->order_status;
                $successorder->fullname = $client_info->fullname;
                $successorder->phone = $client_info->phone;
                $successorder->address = $client_info->city->name.','.$client_info->area->name;
                $successorder->order_count = $orderinfo->product_count;
                $successorder->order_price = $orderinfo->price;
                $successorder->count = $request->sold_product_count;
                $successorder->price = $request->sold_product_price;
        
                $successorder->container = $request->container;
                $successorder->invalid_container_count = $request->invalid_container_count;
        
                $successorder->order_date = $orderinfo->created_at;
        
                $successorder->payment = $request->payment;
        
                if($request->payment == 3) 
                    if( $y >= $request->sold_product_count * $request->sold_product_price){
        
                        $successorder->amount = $request->sold_product_count * $request->sold_product_price;
                        $successorder->client_price = $y;
                        $successorder->price_sold = $request->sold_product_count * $request->sold_product_price;
                    } else 
                        {
                            if($y >= 0) {
                                $successorder->amount = $y;
                                $successorder->client_price = $y;
                                $successorder->price_sold =  $y - $request->sold_product_count * $request->sold_product_price;
                            }
                            else {
                                $successorder->amount = 0;
                                $successorder->client_price = $y;
                                $successorder->price_sold = (-1) * $request->sold_product_count * $request->sold_product_price;
                            }
                        }
                else 
                    $successorder->amount = $request->amount;
                    $successorder->client_price = $y;
                    if($y>=0)
                        $successorder->price_sold = $y + $request->amount - $request->sold_product_count * $request->sold_product_price;
                            else 
                    $successorder->price_sold = $request->amount - $request->sold_product_count * $request->sold_product_price;
        
                $successorder->comment = $request->comment?? '';
        
                $successorder->status = 0;
        
                $successorder->save();
        
                $or = Order::find($id);
                $or->status = 1;
                $or->save();
                
                $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
                $info_org = Organization::find($info_id);
        
                if ($request->order_status == 1 || $request->order_status == 2 ) {
        
                    $clientprice = new ClientPrices();
                    $clientprice->organization_id = $info_id;
                    $clientprice->success_order_id = $successorder->id;
                    $clientprice->client_id = $client_info->id;
                    $clientprice->user_id = Auth::user()->id;
                    $clientprice->payment = $request->payment;
                    $clientprice->amount = $request->amount;
                    $clientprice->comment = 'Dostavka vaqtida';
                    $clientprice->status = 0;
                    $clientprice->save();
        
                    if(Product::find($orderinfo->product_id)->container_status != 1) {
                        $clientcontainer = new ClientContainer();
                        $clientcontainer->organization_id = $info_id;
                        $clientcontainer->success_order_id = $successorder->id;
                        $clientcontainer->client_id = $client_info->id;
                        $clientcontainer->user_id = Auth::user()->id;
                        $clientcontainer->product_id = $orderinfo->product_id;
                        $clientcontainer->count = $request->container;
                        $clientcontainer->invalid_count = $request->invalid_container_count; 
                        $clientcontainer->comment = 'Dostavka vaqtida'; 
                        $clientcontainer->status = 0;
                        $clientcontainer->save();
                    }
                  
        
                    if($info_org->sms_count < $info_org->traffic->sms_count  + $info_org->location) {

                        $char = ['(', ')', ' ','-','+'];
                        $replace = ['', '', '','',''];
                        $phone = str_replace($char, $replace, $client_info->phone);
                        $text = "Poluchena ".$request->amount.", Dostavleno ".$request->sold_product_count.", Vozvrat tari ".
                        $request->container.", Predoplata ".Client::find($x)->balance.". Spasibo za pokupku";
                        $curl = curl_init();
                      
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => 'http://sms.etc.uz:8084/json2sms',
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => '',
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => 'POST',
                          CURLOPT_POSTFIELDS =>"{
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
                        ));
                        
                        $response = curl_exec($curl);
                        $json = json_decode($response, true);
                        
                        if ($json['query_state'] == "SUCCESS") {         
                
                            $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
                            $count = Organization::find($organ);
                            $count->sms_count = $count->sms_count + 1;
                            $count->save();
                
                            $sms = new Sms();
                            $sms->organization_id = $organ;
                            $sms->client_id = $client_info->id;
                            $sms->user_id = Auth::user()->id;
                            $sms->city_id = $client_info->city_id;
                            $sms->area_id = $client_info->area_id;
                            $sms->fullname = $client_info->fullname;
                            $sms->phone = $client_info->phone;
                            $sms->sms_text = $text;
                            $sms->save();
                        }
                    }
                    
                    
                }

                $client_info = Client::find($orderinfo->client_id);

                return response()->json(['message' => 'success','balance' => $client_info->balance,'container' => $client_info->container]);
            }
    }

    public function results(Request $request) {
    
        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $users = UserOrganization::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $x = 0;
        $y = [];
        foreach ($users as $user) {
            $x ++;
            $y[$x] = $user->user_id;
        }

        $data = User::whereIn('id',$y)->get();
        $order = [];
        $takeproduct = [];
        $soldproducts = [];
        $soldsumm = [];
        $entrycon = [];
        $payment1 = [];
        $payment2 = [];
        $payment3 = [];
        $amount = [];
        $roles = [];

        foreach ( $data as $user ) {
            $order[$user->id] = Order::
            where('user_id',$user->id)
            ->whereDate('created_at','>=',$date1)
            ->whereDate('created_at','<=',$date2)
            ->sum('product_count');
            $takeproduct[$user->id] = TakeProduct::whereDate('created_at','>=',$date1)
            ->whereDate('created_at','<=',$date2)
            ->where('received_id', $user->id)
            ->sum('product_count');
            $solds = SuccessOrders::whereDate('created_at','>=',$date1)
            ->whereDate('created_at','<=',$date2)
            ->where('user_id', $user->id)
            ->whereIn('order_status',[1,2])->get();
            $solds2 = ClientPrices::whereDate('created_at','>=',$date1)
            ->whereDate('created_at','<=',$date2)
            ->where('user_id', $user->id)->get();

            $soldproducts[$user->id] = $solds->sum('count');
            $roles[$user->id] = UserOrganization::where('user_id',$user->id)->value('role');
            $soldsumm[$user->id] = 0; 
            $amount[$user->id] = 0;
            $payment1[$user->id] = 0; 
            $payment2[$user->id] = 0;
            $payment3[$user->id] = 0;  

            foreach ($solds as $sold) {

                if($sold->count * $sold->price >= $sold->amount)
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->count * $sold->price;
                else
                $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->amount;

                if($sold->price_sold < 0) $amount[$user->id] = $amount[$user->id] + $sold->price_sold;
                
            }

            foreach ($solds2 as $sold) {
               if($sold->status == 1) $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->amount;

                if($sold->payment == 1) $payment1[$user->id] = $payment1[$user->id] + $sold->amount;
                if($sold->payment == 2) $payment2[$user->id] = $payment2[$user->id] + $sold->amount;
                if($sold->payment == 3) $payment3[$user->id] = $payment3[$user->id] + $sold->amount;
            }
            $summorder = array_sum($order);
            $summtakeproduct = array_sum($takeproduct);
            $summsoldproducts = array_sum($soldproducts);
            $summsoldsumm = array_sum($soldsumm);
            
            $summpayment1 = array_sum($payment1);
            $summpayment2 = array_sum($payment2);
            $summpayment3 = array_sum($payment3);
            

            $entrycon[$user->id] = SuccessOrders::
            where('organization_id',$info_id)
            ->whereDate('created_at','>=',$date1)
            ->whereDate('created_at','<=',$date2)
            ->where('user_id', $user->id)
            ->sum('container');

            $takecon[$user->id] = EntryContainer::
            where('organization_id',$info_id)
            ->whereDate('created_at','>=',$date1)
            ->whereDate('created_at','<=',$date2)
            ->where('user_id', $user->id)
            ->sum('product_count');
            
            $summentrycon = array_sum($entrycon);
            $amount[$user->id] = (-1)*$amount[$user->id];
            $dolgsumm = array_sum($amount);
            $takesumm = array_sum($takecon);
        }
        return view('results',[
            'info_org' => $info_org,
            'roles' => $roles,
            'data'  => $data,
            'order' => $order,
            'takeproduct' => $takeproduct,
            'soldproducts' => $soldproducts,
            'soldsumm' => $soldsumm,
            'dolgsumm' => $dolgsumm,
            'entrycon' => $entrycon,
            'takecon' => $takecon,
            'amount'   => $amount,
            'payment1' => $payment1,
            'payment2' => $payment2,
            'payment3'   => $payment3,
            'summorder' => $summorder,
            'summtakeproduct' => $summtakeproduct,
            'summsoldproducts' => $summsoldproducts,
            'summsoldsumm' => $summsoldsumm,
            'summentrycon' => $summentrycon,
            'summpayment1' => $summpayment1,
            'summpayment2' => $summpayment2,
            'summpayment3' => $summpayment3,
            'takesumm' => $takesumm
        ]);
    }

    public function success_order(Request $request,$id)
    {
        //dd($request->all());
        $orderinfo = Order::find($id);

        $client_info = Client::find($orderinfo->client_id);
        $x = $orderinfo->client_id;
        
        $y = $client_info->balance;

        if ($request->order_status == 1 || $request->order_status == 2 ) {

            $client_info->balance = $client_info->balance  - ($request->product_count * $request->price) + $request->amount;
       
            if(Product::find($orderinfo->product_id)->container_status != 1)
                $client_info->container = $client_info->container - $request->product_count + $request->container - $request->invalid_container_count;
            
            $client_info->save();
        }

        $successorder = new SuccessOrders();
        $successorder->organization_id = $orderinfo->organization_id;
        $successorder->client_id = $orderinfo->client_id;
        $successorder->product_id = $orderinfo->product_id;
        $successorder->user_id = Auth::user()->id;
        $successorder->order_user_id = $orderinfo->user_id;
        $successorder->order_status = $request->order_status;
        $successorder->fullname = $client_info->fullname;
        $successorder->phone = $client_info->phone;
        $successorder->address = $client_info->city->name.','.$client_info->area->name;
        $successorder->order_count = $orderinfo->product_count;
        $successorder->order_price = $orderinfo->price;
        $successorder->count = $request->product_count;
        $successorder->price = $request->price;

        $successorder->container = $request->container;
        $successorder->invalid_container_count = $request->invalid_container_count;

        $successorder->order_date = $orderinfo->created_at;

        $successorder->payment = $request->payment;

        if($request->payment == 3) 
            if( $y >= $request->product_count * $request->price){

                $successorder->amount = $request->product_count * $request->price;
                $successorder->client_price = $y;
                $successorder->price_sold = $request->product_count * $request->price;
            } else 
                {
                    if($y >= 0) {
                        $successorder->amount = $y;
                        $successorder->client_price = $y;
                        $successorder->price_sold =  $y - $request->product_count * $request->price;
                    }
                    else {
                        $successorder->amount = 0;
                        $successorder->client_price = $y;
                        $successorder->price_sold = (-1) * $request->product_count * $request->price;
                    }
                }
        else 
            $successorder->amount = $request->amount;
            $successorder->client_price = $y;
            if($y>=0)
                $successorder->price_sold = $y + $request->amount - $request->product_count * $request->price;
                    else 
            $successorder->price_sold = $request->amount - $request->product_count * $request->price;

        $successorder->comment = $request->comment?? '';

        $successorder->status = 0;

        $successorder->save();

        $or = Order::find($id);
        $or->status = 1;
        $or->save();
        
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        if ($request->order_status == 1 || $request->order_status == 2 ) {

            $clientprice = new ClientPrices();
            $clientprice->organization_id = $info_id;
            $clientprice->success_order_id = $successorder->id;
            $clientprice->client_id = $client_info->id;
            $clientprice->user_id = Auth::user()->id;
            $clientprice->payment = $request->payment;
            $clientprice->amount = $request->amount;
            $clientprice->comment = $request->comment ?? '';
            $clientprice->status = 0;
            $clientprice->save();

            if(Product::find($orderinfo->product_id)->container_status != 1) {
                $clientcontainer = new ClientContainer();
                $clientcontainer->organization_id = $info_id;
                $clientcontainer->success_order_id = $successorder->id;
                $clientcontainer->client_id = $client_info->id;
                $clientcontainer->user_id = Auth::user()->id;
                $clientcontainer->product_id = $orderinfo->product_id;
                $clientcontainer->count = $request->container;
                $clientcontainer->invalid_count = $request->invalid_container_count; 
                $clientcontainer->comment = $request->comment ?? ''; 
                $clientcontainer->status = 0;
                $clientcontainer->save();
            }
          

            if($info_org->sms_count < $info_org->traffic->sms_count + $info_org->location) {
                $char = ['(', ')', ' ','-','+'];
                $replace = ['', '', '','',''];
                $phone = str_replace($char, $replace, $client_info->phone);
                $text = "Poluchena ".$request->amount.", Dostavleno ".$request->product_count.", Vozvrat tari ".
                $request->container.", Predoplata ".Client::find($x)->balance.". Spasibo za pokupku";
                $curl = curl_init();
            
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://sms.etc.uz:8084/json2sms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{
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
                ));
                
                $response = curl_exec($curl);
                $json = json_decode($response, true);
                
                if ($json['query_state'] == "SUCCESS") {         
        
                    $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
                    $count = Organization::find($organ);
                    $count->sms_count = $count->sms_count + 1;
                    $count->save();
                    
                    $sms = new Sms();
                    $sms->organization_id = $organ;
                    $sms->client_id = $client_info->id;
                    $sms->user_id = Auth::user()->id;
                    $sms->city_id = $client_info->city_id;
                    $sms->area_id = $client_info->area_id;
                    $sms->fullname = $client_info->fullname;
                    $sms->phone = $client_info->phone;
                    $sms->sms_text = $text;
                    $sms->save();
                }
            }

            
            
        }

        return redirect()->route('status_client',['id' => $x]);
    }

    public function status_client($id)
    {
        $client_info = Client::find($id);
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('clients.status_client',[
            'client_info' => $client_info,
            'info_org'  => $info_org
        ]);
    }

    public function products()
    {
        $products = Product::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        if($info_org->date_traffic < now()) 
        return view('error');

        return view('products.products',[
            'products' => $products,
            'info_org'  => $info_org
        ]);
    }
    public function add_product(Request $request)
    {
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $count = Organization::find($organ);

        if($count->products_count < $count->traffic->products_count)
        {
            if($request->photo != null){
                $fileName = time().'.'.$request->photo->extension();
                $path = $request->photo->storeAs('products', $fileName);
            }
            
            $product = new Product();
            $product->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');;
            $product->name = $request->name;
            $product->container_status = $request->idish_status;
            $product->price = $request->sena;
            $product->product_count = $request->count;
            $product->container = 0;
    
            if($request->photo != null){
                $product->photo =  'storage/products/' . $fileName;
            } else  $product->photo = '';
           
            $product->save();

            $count = Organization::find($organ);
            $count->products_count = $count->products_count + 1;
            $count->save();
    
            return redirect()->back()->with('msg' ,'success');
        } else  return redirect()->back()->with('msg' ,'error');
       
    }

    public function workers()
    {
        $workers = UserOrganization::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('users')->get();
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        if($info_org->date_traffic < now()) 
        return view('error');
        
        return view('workers',[
            'workers' => $workers,
            'info_org' => $info_org
        ]);
    }

    public function regions()
    {
        $regions = Sity::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        if($info_org->date_traffic < now()) 
        return view('error');

        return view('regions',[
            'regions' => $regions,
            'info_org' => $info_org
        ]);
    }

    public function cities()
    {
        $regions = Sity::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $areas = Area::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('region')->get();
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('cities',[
            'regions' => $regions,
            'areas' => $areas,
            'info_org' => $info_org
        ]);
    }

    public function edit_region(Request $request, $id)
    {
        $region = Sity::find($id);
        $region->name = $request->region_name;
        $region->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_region($id)
    {
        Sity::find($id)->delete();
        Area::where('city_id', $id)->delete(); 

        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_city(Request $request, $id)
    {
        $sity = Area::find($id);
        $sity->city_id = $request->sity_id;
        $sity->name = $request->area_name;
        $sity->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_city($id)
    {
        $sity = Area::find($id)->delete();

        return redirect()->back()->with('msg' ,'success');
    }

    public function driver_regions()
    {
        
        return response()->json(
            Sity::where('organization_id',UserOrganization::where('user_id', Auth::user()->id)->value('organization_id'))->with('areas')->get()
        );
    }
    public function areas(Request $request)
    {
        return response()->json(Area::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
        ->where('city_id',$request->region_id)->with(['region'])->get());
    }

    public function monitoring()
    {
        return response()->json(SuccessOrders::
        where('user_id', Auth::user()->id)
        ->whereDate('created_at', now())
        ->with(['product' , 'client','client.city', 'client.area'])
        ->get());
    }

    public function areas_filter(Request $request)
    {
        $str = implode(',',$request->areas);

        if(RegionUser::where('user_id',Auth::user()->id)->count() == 0) {
            $areas = new RegionUser();
            $areas->user_id = Auth::user()->id;
            $areas->areas = $str;
            $areas->save();
        } else
        {
            $id = RegionUser::where('user_id',Auth::user()->id)->value('id');
            $areas = RegionUser::find($id);
            $areas->areas = $str;
            $areas->save();
        }
        return response()->json(['message' => 'success']);
    }
}
