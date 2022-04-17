<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\UserOrganization;
use App\Models\User;
use App\Models\Traffic;
use App\Models\Organization;
use Spatie\Permission\Models\Role;
use App\Models\TrafficOrganization;
use App\Models\PriceOrganization;
use App\Models\ActiveTraffic;

class TrafficController extends Controller
{
    
    public function user_organizations()
    {
        $users = UserOrganization::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $x = 0;
        $y = [];
        foreach ($users as $user) {
            $x ++;
            $y[$x] = $user->user_id;
        }
        $data = User::whereIn('id',$y)->get();
        return view('administration.users',[
            'data' => $data
        ]);
    }

    public function organizations()
    {
        $organizations = Organization::with('traffic')->with('traffic')->get();
        $traffics = Traffic::all();
        
        $sname = 'organizations';

        return view('administration.organizations',[
            'organizations' => $organizations,
            'traffics' => $traffics,
            'sname' => $sname
        ]);
    }


    public function traffics()
    {
        $traffics = Traffic::all();

        $x = explode(',',ActiveTraffic::find(1)->string1);

            $q = [];
            foreach ($traffics as $traffic) {
                $q[$traffic->id] = false;
                foreach ($x as $y) {
                    if($traffic->id == $y) 
                    {
                        $q[$traffic->id] = true;
                        break;
                    }
                   
                }
            }

        return view('administration.traffics',[
            'traffics' => $traffics,
            'q' => $q
        ]);
      
    }
    public function add_traffic(Request $request)
    {
        //dd($request->all());
        $traffic = new Traffic();
        $traffic->name = $request->name;
        $traffic->annotation = $request->annotation;
        $traffic->price = $request->price;
        $traffic->clients_count = $request->clients_count;
        $traffic->sms_count = $request->sms_count;
        $traffic->products_count = $request->products_count;
        $traffic->users_count = $request->users_count;
        $traffic->status = $request->status;
        $traffic->style1 = $request->style1 ?? 'pricing body good-grp';
        $traffic->style2 = $request->style2 ?? 'pricing-plan personal';
        $traffic->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_traffic(Request $request, $id)
    {
        $traffic = Traffic::find($id);
        $traffic->name = $request->name;
        $traffic->annotation = $request->annotation;
        $traffic->price = $request->price;
        $traffic->clients_count = $request->clients_count;
        $traffic->sms_count = $request->sms_count;
        $traffic->products_count = $request->products_count;
        $traffic->users_count = $request->users_count;
        $traffic->status = $request->status;
        $traffic->style1 = $request->style1 ?? 'pricing body good-grp';
        $traffic->style2 = $request->style2 ?? 'pricing-plan personal';
        $traffic->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function add_organization(Request $request)
    {
        $traffic = Traffic::find($request->traffic_id);

        $organizations = new Organization();
        $organizations->name = $request->name;
        $organizations->director_name = $request->director_name;
        $organizations->phone = $request->phone;
        $organizations->location = $request->location;
        $organizations->traffic_id = $request->traffic_id;

        
        $organizations->balance = (-1) * $traffic->price;
        $organizations->clients_count = 0;
        $organizations->sms_count = 0;
        $organizations->products_count = 0;
        $organizations->users_count = 1;

        
        $organizations->date_traffic = $request->date_traffic;

        $organizations->comment = $request->comment ?? '';
        $organizations->save();

        $char = ['(', ')', ' ','-','+'];
        $replace = ['', '', '','',''];
        $phone1 = str_replace($char, $replace, $request->phone);

        $phone = substr(str_replace($char, $replace, $request->phone), 5, 4);

        $user = new User();
        $user->name = $request->director_name;
        $user->email = 'director'.$phone.'@gmail.com';
        $user->password = bcrypt($phone1);
        $user->save();

        $pers = [
            'bosh-menu',
            'clients',
            'orders',
            'regions',
            'sklad',
            'smsmanager',
            'results',
            'products',
            'users',
            'director',
            'per-delete'
         ];
        $user->givePermissionTo($pers);

        $userorgan = new UserOrganization();
        $userorgan->user_id = $user->id;
        $userorgan->organization_id = $organizations->id;
        $userorgan->role = 4;
        $userorgan->save();

        $trafficorgan = new TrafficOrganization();
        $trafficorgan->traffic_id = $request->traffic_id;
        $trafficorgan->organization_id = $organizations->id;
        $trafficorgan->date_from = now()->format('Y-m-d');
        $trafficorgan->date_to = $request->date_traffic;
        $trafficorgan->price = $traffic->price;
        $trafficorgan->comment = '';
        $trafficorgan->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_organization(Request $request, $id)
    {

        $organizations = Organization::find($id);
        $organizations->name = $request->name;
        $organizations->director_name = $request->director_name;
        $organizations->phone = $request->phone;
        $organizations->location = $request->location;
        $organizations->date_traffic = $request->date_traffic;
        $organizations->comment = $request->comment ?? '';
        $organizations->save();

        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_organization($id)
    {
        Organization::find($id)->delete();
        $users = UserOrganization::where('organization_id',$id)->get();

        foreach ($users as $user) {
            User::find($user->user_id)->delete();
        }
        PriceOrganization::where('organization_id',$id)->delete();
        TrafficOrganization::where('organization_id',$id)->delete();
        UserOrganization::where('organization_id',$id)->delete();

        return redirect()->back()->with('msg' ,'success');
    }

    public function indexpriceorgan($id)
    {
        
        $organization = Organization::find($id);
        $priceorgan = PriceOrganization::where('organization_id',$id)->get();
        
        return view('administration.addpricemerchant',[
            'organization' => $organization,
            'priceorgan'   => $priceorgan
        ]);   
     
    }

    public function trafficorgan($id)
    {
        $traffics = Traffic::all();
        $organization = Organization::find($id);
        $trafficorgan = TrafficOrganization::where('organization_id',$id)->get();
        
        return view('administration.trafficorgan',[
            'organization' => $organization,
            'trafficorgan'   => $trafficorgan,
            'traffics'  => $traffics
        ]);   
     
    }


    
    public function add_price_organization(Request $request, $id)
    {
        $price = new PriceOrganization();  
        $price->organization_id = $id;
        $price->payment = $request->payment; 
        $price->price = $request->price; 
        $price->comment = $request->comment ?? ''; 
        $price->save();

        $org = Organization::find($id);
        $org->balance = $org->balance + $request->price;
        $org->save();
     
        return redirect()->back()->with('msg' ,'success');
    }

    public function edit_price_organization(Request $request, $id)
    {
        $price = PriceOrganization::find($id);

        $org = Organization::find($price->organization_id);
        $org->balance = $org->balance - $price->price + $request->price;
        $org->save();

        $price->payment = $request->payment; 
        $price->price = $request->price; 
        $price->comment = $request->comment ?? ''; 
        $price->save();
     
        return redirect()->back()->with('msg' ,'success');
    }

    public function delete_price_organization($id)
    {
        $price = PriceOrganization::find($id);

        $org = Organization::find($price->organization_id);
        $org->balance = $org->balance - $price->price;
        $org->save();

        $price = PriceOrganization::find($id)->delete();
     
        return redirect()->back()->with('msg' ,'success');
    }
        
    public function add_traffic_organization(Request $request, $id)
    {
        $traffic = Traffic::find($request->traffic_id);

        $trafficorgan = new TrafficOrganization(); 
        $trafficorgan->traffic_id = $request->traffic_id; 
        $trafficorgan->organization_id = $id;
        $trafficorgan->date_from = $request->date_from; 
        $trafficorgan->date_to = $request->date_to; 
        $trafficorgan->price = $traffic->price; 
        $trafficorgan->comment = $request->comment ?? ''; 
        $trafficorgan->save();

        $organizations = Organization::find($id);
        $organizations->traffic_id = $request->traffic_id; 
        $organizations->balance = $organizations->balance + (-1 * $traffic->price);
        $organizations->date_traffic = $request->date_to;
        $organizations->save();
     
        return redirect()->back()->with('msg' ,'success');
    }

}
