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
use App\Models\Traffic;
use App\Models\Product;
use App\Models\User;
use App\Models\Sity;
use App\Models\Area;
use App\Models\Sms;
use Auth;

class ClientController extends Controller
{
    public function view_location($id)
    {
        $client = Client::find($id);
        $locations[0] = $client->fullname;

        $arr = explode(',',$client->location);

        $locations[1] = $arr[0];
        $locations[2] = $arr[1];
        $locations[3] = 1;

        return view('clients.viewlocation',[
            'locations' => $locations
        ]);
    }

    public function client_price(Request $request, $id)
    {
        $clientprice = new ClientPrices();
        $clientprice->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
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
        

       
        return redirect()->back()->with('msg' ,'success');
    }

    public function client_price_edit(Request $request, $id)
    {
        $clientprice = ClientPrices::find($id);
        if($clientprice->status == 1) {
            $price = $clientprice->amount;
            $clientprice->payment = $request->payment;
            $clientprice->amount = $request->amount;
            $clientprice->comment = $request->comment ?? ''; 
            $clientprice->save();
    
            $client = Client::find($clientprice->client_id);
            $client->balance = $client->balance - $price +  $request->amount;
            $client->save();
        } else {
            $price = $clientprice->amount;
            $clientprice->payment = $request->payment;
            $clientprice->amount = $request->amount;
            $clientprice->comment = $request->comment ?? ''; 
            $clientprice->save();
    
            $client = Client::find($clientprice->client_id);
            $client->balance = $client->balance - $price +  $request->amount;
            $client->save();

            $succ = SuccessOrders::find($clientprice->success_order_id);
            $succ->amount = $request->amount;
            $succ->price_sold = $request->amount - ($succ->count * $succ->price);
            $succ->save();
        }
        

       
        return redirect()->back()->with('msg' ,'success');
    }

    public function client_price_delete( $id)
    {
        $clientprice = ClientPrices::find($id);
        $price = $clientprice->amount;

        $client = Client::find($clientprice->client_id);
        $client->balance = $client->balance - $price;
        $client->save();
        $clientprice->delete();
       
        return redirect()->back()->with('msg' ,'success');
    }

    public function client_container(Request $request, $id)
    {
        $clientprice = new ClientContainer();
        $clientprice->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
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

       
        return redirect()->back()->with('msg' ,'success');
    }

    public function client_container_edit(Request $request, $id)
    {
        $clientprice = ClientContainer::find($id);
        if($clientprice->status == 1) {
            $count = $clientprice->count;
            $incount = $clientprice->invalid_count;
    
            $clientprice->product_id = $request->product_id;
            $clientprice->count = $request->count;
            $clientprice->invalid_count = $request->invalid_count; 
            $clientprice->comment = $request->comment ?? ''; 
            $clientprice->save();
    
            $client = Client::find($clientprice->client_id);
            $client->container = $client->container - ($count-$incount) + $request->count - $request->invalid_count;
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
            $client->container = $client->container - ($count-$incount) + $request->count - $request->invalid_count;
            $client->save();

            $succ = SuccessOrders::find($clientprice->success_order_id);
            $succ->container = $request->count;
            $succ->invalid_container_count = $request->invalid_count;
            $succ->save();
        }

        return redirect()->back()->with('msg' ,'success');
    }
    public function client_container_delete($id)
    {
        $clientprice = ClientContainer::find($id);
        $count = $clientprice->count;
        $incount = $clientprice->invalid_count;

        $client = Client::find($clientprice->client_id);
        $client->container = $client->container - ($count-$incount);
        $client->save();

        $clientprice->delete();
       
        return redirect()->back()->with('msg' ,'success');
    }

    public function success_order_view($id)
    {  
        $order = Order::find($id);
        $summ = $order->product_count * $order->price;
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('clients.success_order',[
            'order' => $order,
            'summ' => $summ,
            'info_org' => $info_org
        ]);
    }

    public function take_products()
    {  
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $takeproducts = TakeProduct::where('organization_id',$info_id)
        ->orderBy('created_at', 'DESC')
        ->with('received')->with('sent')->with('product');

        $products = Product::where('organization_id', $info_id)->get();
    
        $arr = UserOrganization::where('organization_id', $info_id)->pluck('user_id')->toArray();
       
        $users = User::whereIn('id',$arr)->get();
        
        $info_org = Organization::find($info_id);


        return view('sklad.take-product',[
            'takeproducts' => $takeproducts->paginate(10),
            'products' => $products,
            'users' => $users,
            'info_org' => $info_org
        ]);
    }

    public function entry_products()
    {  
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $entryproduct = EntryProduct::where('organization_id',$info_id)
        ->orderBy('created_at', 'DESC')
        ->with('user')->with('product');

        $products = Product::where('organization_id', $info_id)->get();
       
        $info_org = Organization::find($info_id);

        return view('sklad.entry-product',[
            'entryproduct' => $entryproduct->paginate(10),
            'products' => $products,
            'info_org' => $info_org
        ]);
    }

    public function entry_container()
    {  
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $entrycontainer = EntryContainer::where('organization_id',$info_id)
        ->orderBy('created_at', 'DESC')
        ->with('user')
        ->with('received')
        ->with('product');

        $products = Product::where('organization_id', $info_id)->get();
    
        $arr = UserOrganization::where('organization_id', $info_id)->pluck('user_id')->toArray();
       
        $users = User::whereIn('id',$arr)->get();
       
        $info_org = Organization::find($info_id);

        return view('sklad.entry-container',[
            'entrycontainer' => $entrycontainer->paginate(10),
            'products' => $products,
            'users' => $users,
            'info_org' => $info_org
        ]);
    }

    public function take_container()
    {  
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $takecontainer = TakeContainer::where('organization_id',$info_id)
        ->orderBy('created_at', 'DESC')
        ->with('user')
        ->with('product');

        $products = Product::where('organization_id', $info_id)->get();
        
        $info_org = Organization::find($info_id);

        return view('sklad.take-container',[
            'takecontainer' => $takecontainer->paginate(10),
            'products' => $products,
            'info_org' => $info_org
        ]);
    }

    public function add_take_product(Request $request)
    {  
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

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
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function take_edit_product(Request $request, $id)
    {  
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
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function take_delete_product(Request $request, $id)
    {  
        $takproduct = TakeProduct::find($id);
        $old = $takproduct->product_count;
        $oldid = $takproduct->product_id;

        $prod = Product::find($oldid);
        $prod->product_count = $prod->product_count + $old;
        $prod->save();
        $takproduct->delete();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function add_entry_product(Request $request)
    {  
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $entryproduct = new EntryProduct();
        $entryproduct->organization_id = $organ;
        $entryproduct->product_id = $request->product_id;
        $entryproduct->user_id = Auth::user()->id;
        $entryproduct->product_count = $request->product_count;
        $entryproduct->price = $request->price;
        $entryproduct->comment = $request->comment?? '';
        $entryproduct->save();

        $prod = Product::find($request->product_id);
        $prod->product_count = $prod->product_count + $request->product_count;
        $prod->save();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_entry_product(Request $request, $id)
    {  
        $entryproduct = EntryProduct::find($id);

        $entryproduct->product_id = $request->product_id;
        $entryproduct->user_id = Auth::user()->id;
        $old = $entryproduct->product_count;
        $entryproduct->product_count = $request->product_count;
        $entryproduct->price = $request->price;
        $entryproduct->comment = $request->comment?? '';
        $entryproduct->save();

        $prod = Product::find($request->product_id);
        $prod->product_count = $prod->product_count - $old + $request->product_count;
        $prod->save();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_entry_product($id)
    {  
        $entryproduct = EntryProduct::find($id);
        $old = $entryproduct->product_count;
        $oldid = $entryproduct->product_id;

        $entryproduct->save();

        $prod = Product::find($oldid);
        $prod->product_count = $prod->product_count - $old;
        $prod->save();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function add_entry_container(Request $request)
    {  
        //dd($request->all());
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

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
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_entry_container(Request $request, $id)
    {  
        
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
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_entry_container($id)
    {  
        
        $entrycontainer = EntryContainer::find($id);
        $prodid = $entrycontainer->product_id;
        $old = $entrycontainer->product_count;

        $prod = Product::find($prodid);
        $prod->container = $prod->container - $old;
        $prod->save();     
        $entrycontainer->delete();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_product(Request $request, $id)
    {  
        if($request->photo != null){
            $fileName = time().'.'.$request->photo->extension();
            $path = $request->photo->storeAs('products', $fileName);
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        
        if($request->photo != null){
            $product->photo =  'storage/products/' . $fileName;
        } else  $product->photo = '';
       
        $product->save();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_product($id)
    {  
        $product = Product::find($id)->delete();
        
        return redirect()->back()->with('msg' ,'success');
    }
    
    public function take_entry_container(Request $request)
    {  
       // dd($request->all());
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $entrycontainer = new TakeContainer();
        $entrycontainer->organization_id = $organ;
        $entrycontainer->user_id = Auth::user()->id;
        $entrycontainer->product_id = $request->product_id;
        $entrycontainer->product_count = $request->product_count;
        $entrycontainer->comment = $request->comment?? '';
        $entrycontainer->save();

        $prod = Product::find($request->product_id);
        $prod->container = $prod->container - $request->product_count;
        $prod->save();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function take_edit_container(Request $request, $id)
    {  
        $entrycontainer = TakeContainer::find($id);
        $entrycontainer->user_id = Auth::user()->id;
        $entrycontainer->product_id = $request->product_id;
        $old = $entrycontainer->product_count;

        $entrycontainer->product_count = $request->product_count;
        $entrycontainer->comment = $request->comment?? '';
        $entrycontainer->save();

        $prod = Product::find($request->product_id);
        $prod->container = $prod->container - $request->product_count + $old;
        $prod->save();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function take_delete_container($id)
    {  
        $entrycontainer = TakeContainer::find($id);
        $old = $entrycontainer->product_count;
        $oldid = $entrycontainer->product_id;

        $prod = Product::find($oldid);
        $prod->container = $prod->container + $old;
        $prod->save();
        $entrycontainer->delete();
        
        return redirect()->back()->with('msg' ,'success');
    }

    public function send_message(Request $request)
    {  
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
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

        $sities = Sity::where('organization_id',$organ)->get();
        $areas = Area::where('city_id', request('city_id', 0))->get();

        $products = Product::where('organization_id', $organ)->get();
        $info_org = Organization::find($organ);
        $client_count = $clients->count();
        if(!$request->paginate) $paginate = 10; else $paginate = $request->paginate;
        return view('smsmanager.sendmessage',[
            'clients' => $clients->paginate($paginate),
            'sities' => $sities,
            'areas' => $areas,
            'products' => $products,
            'info_org' => $info_org,
            'client_count' => $client_count
        ]);
    }

    public function sms_text()
    {  
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('smsmanager.smstext',[
            'info_org' => $info_org
        ]);
    }

    public function success_message()
    {  
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $smsmanagers = Sms::where('organization_id', $organ)
        ->orderBy('created_at', 'DESC')
        ->with('client')
        ->with('user');

        $info_org = Organization::find($organ);

        return view('smsmanager.successmessage',[
            'smsmanagers' => $smsmanagers->paginate(10),
            'info_org' => $info_org
        ]);
    }


    public function send_client_message($text, $phone_number, $id)
    {  
        
        $char = ['(', ')', ' ','-','+'];
        $replace = ['', '', '','',''];
        $phone = str_replace($char, $replace, $phone_number);

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
        $organ = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $count = Organization::find($organ);

        if($count->sms_count < $count->traffic->sms_count + $count->location) {
            
            $arr = $request->checkbox;
            $x = 0;
    
            foreach ($arr as $key => $value) { 

                $phone_number = Client::find($key)->phone;
                if ( $this->send_client_message($request->text, $phone_number, $key) == 1 ) $x++;

                $count = Organization::find($organ);
                if($count->sms_count >= $count->traffic->sms_count ) break;
            }

            return redirect()->back()->with('msg' , $x);

        } else 
        
        return redirect()->back()->with('msg' , 0);

       
    }

    public function client_profile(Request $request)
    {
        //dd($request->all());

        $error = '
        {
            "error" : "Unauthorized"
        }
        ';

        $client = Client::where('login',$request->login)->where('password',$request->password)->get();

        if(count($client)) return  $client;
        else
            return json_decode($error, true); 
    }

    public function resultorders(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $orders = Order::whereDate('created_at','>=',$date1)
        ->whereDate('created_at','<=',$date2)
        ->where('organization_id', $info_id)->with('client')->with('user')->with('product');
        
        return view('result.resultorders',[
            'orders' => $orders->paginate(10),
            'info_org' => $info_org
        ]);

    }

    public function resulttakeproducts(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $arr = UserOrganization::where('organization_id', $info_id)->pluck('user_id')->toArray();

        $takeproduct = TakeProduct::whereDate('created_at','>=',$date1)
        ->whereDate('created_at','<=',$date2)
        ->where('organization_id',$info_id)
        ->with('received')
        ->with('sent')
        ->with('product')
        ->get();


        return view('result.resulttake',[
            'takeproduct' => $takeproduct,
            'info_org' => $info_org
        ]);

    }

    public function resultsold(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $soldproducts = SuccessOrders::where('organization_id',$info_id)
        ->whereDate('created_at','>=',$date1)
        ->whereDate('created_at','<=',$date2)->get();
       
        $summ = 0;
        foreach ($soldproducts as $sold){
            $summ = $summ + $sold->amount;
        }

        return view('result.soldproduct',[
            'soldproducts' => $soldproducts,
            'summ' => $summ,
            'info_org' => $info_org
        ]);
    }

    public function summresult(Request $request){

       if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $soldproducts = SuccessOrders::where('organization_id',$info_id)->whereDate('created_at','>=',$date1)
        ->whereDate('created_at','<=',$date2)->get();

        $summ = 0;
        foreach ($soldproducts as $sold){
            $summ = $summ + $sold->amount;
        }

        return view('result.summ',[
            'soldproducts' => $soldproducts,
            'summ' => $summ,
            'info_org' => $info_org
        ]);
    }

    public function resultentrycontainer(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $entrycontainer = SuccessOrders::whereDate('created_at','>=',$date1)
        ->whereDate('created_at','<=',$date2)
        ->where('organization_id',$info_id)
        ->with('user')
        ->has('client')
        ->with('product')->get();

        $summ_con = $entrycontainer->sum('container');
        $summ_con_in = $entrycontainer->sum('invalid_container_count');

        return view('result.resultentryontainer',[
            'entrycontainer' => $entrycontainer,
            'info_org' => $info_org,
            'summ_con' => $summ_con,
            'summ_con_in' => $summ_con_in
        ]);
     }

     public function payment1(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }
        
         $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
         $info_org = Organization::find($info_id);

          $clientprices = ClientPrices::where('organization_id',$info_id)->whereDate('created_at','>=',$date1)
          ->whereDate('created_at','<=',$date2)->where('payment',1)->where('user_id',$request->id)->get();
  
          $summ = 0;
          foreach ($clientprices as $clientprice){
              $summ = $summ + $clientprice->amount;
          }
         return view('result.payment1',[
             'summ' => $summ,
             'clientprices' => $clientprices,
             'info_org' => $info_org
         ]);
     }
     public function payment2(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

         $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
         $info_org = Organization::find($info_id);
 
          $clientprices = ClientPrices::where('organization_id',$info_id)->whereDate('created_at','>=',$date1)
          ->whereDate('created_at','<=',$date2)->where('payment',2)->where('user_id',$request->id)->get();
  
          $summ = 0;
          foreach ($clientprices as $clientprice){
              $summ = $summ + $clientprice->amount;
          }

         return view('result.payment2',[
             'summ' => $summ,
             'clientprices' => $clientprices,
             'info_org' => $info_org
         ]);
     }

     public function payment3(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }
       
         $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
         $info_org = Organization::find($info_id);

          $clientprices = ClientPrices::where('organization_id',$info_id)->whereDate('created_at','>=',$date1)
          ->whereDate('created_at','<=',$date2)->where('payment',3)->where('user_id',$request->id)->get();
  
          $summ = 0;
          foreach ($clientprices as $clientprice){
              $summ = $summ + $clientprice->amount;
          }
 
         return view('result.payment3',[
             'summ' => $summ,
             'clientprices' => $clientprices,
             'info_org' => $info_org
         ]);
     }

     public function dolgresult(Request $request){

        if($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d',strtotime($request->date1));
            $date2 = date('Y-m-d',strtotime($request->date2));
        }

         $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
         $info_org = Organization::find($info_id);

         $soldproducts = SuccessOrders::where('organization_id',$info_id)->whereDate('created_at','>=',$date1)
         ->whereDate('created_at','<=',$date2)
        ->where('price_sold','<',0)->where('user_id',$request->id)
        ->get();
 
         $summ = 0;
         foreach ($soldproducts as $sold){
             $summ = $summ + $sold->amount;
         }
 
         return view('result.dolg',[
             'soldproducts' => $soldproducts,
             'summ' => $summ,
             'info_org' => $info_org
         ]);
     }

     public function admin_traffics(){

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);
        $traffics = Traffic::whereIn('id', explode(',', ActiveTraffic::find(1)->string1))->get();
        
        return view('clients.traffics',[
            'info_org' => $info_org,
            'traffics' => $traffics
        ]);
     }

     public function dolgs(){

        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        $clients = Client::where('organization_id',$info_id)
        ->where(function ($query) {
            $query->where('balance', '<', 0)
                  ->orWhere('container', '<', 0);
                })->orderBy('balance','ASC');
        
        return view('but_results.dolg',[
            'info_org' => $info_org,
            'clients' => $clients->paginate(10)
        ]);
     }

     public function client_products(Request $request) 
     {
         $org_id = Client::find($request->client_id)->organization_id;
         $products = Product::where('organization_id',$org_id)->get();

         return response()->json($products, 200);
     }

     public function client_add_order(Request $request) 
     {
        $order = Order::
        where('client_id',$request->client_id)
        ->where('product_id',$request->product_id)
        ->where('status',0)
        ->get();

        $client = Client::find($request->client_id);
        $product = Product::findOrFail($request->product_id);
        if($order->count() > 0) {
            return response()->json(['error' => 'Unauthorized'], 422);
        }

        $zakaz = new Order();
        $zakaz->organization_id = $client->organization_id;
        $zakaz->city_id = $client->city_id;
        $zakaz->area_id = $client->area_id;
        $zakaz->client_id = $request->client_id;
        $zakaz->product_id = $request->product_id;
        $zakaz->container_status = $product->container_status;
        $zakaz->product_count = $request->count;
        $zakaz->price = $product->price;
        $zakaz->comment = 'Mijoz dastur orqali';
        $zakaz->status = 0;
        $zakaz->user_id = $client->user_id;
        $zakaz->save();

        $client->activated_at = now();
        $client->save();
        
        $orders = Order::where('client_id',$request->client_id)->get();

        return response()->json($orders, 200);
     }
     public function client_order(Request $request) 
     {
        
        $orders = Order::where('client_id',$request->client_id)->with('product')->get();
        
        return response()->json($orders, 200);
     }
}
