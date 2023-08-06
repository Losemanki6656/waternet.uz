<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use App\Models\UserOrganization;
use App\Models\User;
use App\Models\Traffic;
use App\Models\Client;
use App\Models\Organization;
use Spatie\Permission\Models\Role;
use App\Models\TrafficOrganization;
use App\Models\PriceOrganization;
use App\Models\ActiveTraffic;
use App\Models\AdminPhotoSlider;
use App\Models\CartPhoto;
use App\Models\SwiperPhoto;
use App\Models\OrganizationSwiper;
use Illuminate\Support\Facades\Storage;
use File;
use Response;

class TrafficController extends Controller
{

    public function user_organizations()
    {
        $users = UserOrganization::where('organization_id', auth()->user()->organization_id)->get();
        $x = 0;
        $y = [];
        foreach ($users as $user) {
            $x++;
            $y[$x] = $user->user_id;
        }
        $data = User::whereIn('id', $y)->get();
        return view('administration.users', [
            'data' => $data
        ]);
    }

    public function organizations()
    {
        $organizations = Organization::with('traffic')->with('traffic')->get();
        $traffics = Traffic::all();

        $sname = 'organizations';

        return view('administration.organizations', [
            'organizations' => $organizations,
            'traffics' => $traffics,
            'sname' => $sname
        ]);
    }


    public function traffics()
    {
        $traffics = Traffic::all();



        return view('traffics', [
            'traffics' => $traffics
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

        return redirect()->back()->with('msg', 'success');
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

        return redirect()->back()->with('msg', 'success');
    }

    public function add_organization(Request $request)
    {
        $traffic = Traffic::find($request->traffic_id);

        $organizations = new Organization();
        $organizations->name = $request->name;
        $organizations->director_name = $request->director_name;
        $organizations->phone = $request->phone;
        $organizations->location = $request->location ?? '';
        $organizations->traffic_id = $request->traffic_id;


        $organizations->balance = (-1) * $traffic->price;
        $organizations->clients_count = 0;
        $organizations->sms_count = 0;
        $organizations->products_count = 0;
        $organizations->users_count = 1;


        $organizations->date_traffic = $request->date_traffic;

        $organizations->comment = $request->comment ?? '';
        $organizations->save();

        $char = ['(', ')', ' ', '-', '+'];
        $replace = ['', '', '', '', ''];
        $phone1 = str_replace($char, $replace, $request->phone);

        $phone = substr(str_replace($char, $replace, $request->phone), 5, 4);

        $user = new User();
        $user->name = $request->director_name;
        $user->email = 'director' . $phone . '@gmail.com';
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

        return redirect()->back()->with('success', __('messages.new_shop_addedd_successfully'));
    }

    public function edit_organization(Request $request, $id)
    {

        $organizations = Organization::find($id);
        $organizations->name = $request->name;
        $organizations->director_name = $request->director_name;
        $organizations->phone = $request->phone;
        $organizations->location = $request->location ?? '';
        $organizations->date_traffic = $request->date_traffic;
        $organizations->comment = $request->comment ?? '';
        $organizations->save();

        return redirect()->back()->with('success', __('messages.shop_updated_successfully'));
    }

    public function delete_organization(Request $request)
    {
        $id = $request->id;
        try {

            User::where('organization_id', $id)
                ->delete();

            Product::where('organization_id', $id)
                ->delete();
            PriceOrganization::where('organization_id', $id)
                ->delete();

            Client::where('organization_id', $id)
                ->delete();

            TrafficOrganization::where('organization_id', $id)
                ->delete();

            Organization::find($id)
                ->delete();

            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function indexpriceorgan($id)
    {

        $priceorgan = PriceOrganization::where('organization_id', $id)
            ->with('organization')
            ->get();
        $organization = Organization::find($id);

        return view('administration.addpricemerchant', [
            'priceorgan' => $priceorgan,
            'organization' => $organization
        ]);

    }

    public function trafficorgan($id)
    {
        $traffics = Traffic::all();
        $organization = Organization::find($id);
        $trafficorgan = TrafficOrganization::where('organization_id', $id)->get();

        return view('administration.trafficorgan', [
            'organization' => $organization,
            'trafficorgan' => $trafficorgan,
            'traffics' => $traffics
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

        return redirect()->back()->with('success', __('messages.price_added_successfully'));
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

        return redirect()->back()->with('success', __('messages.price_edited_successfully'));
    }

    public function delete_price_organization(Request $request)
    {
        try {

            $id = $request->id;

            $price = PriceOrganization::find($id);

            $org = Organization::find($price->organization_id);
            $org->balance = $org->balance - $price->price;
            $org->save();

            $price = PriceOrganization::find($id)->delete();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function add_traffic_organization(Request $request, $id)
    {
        $traffic = Traffic::find($request->traffic_id);
        if ($traffic->status == 1) {

            $trafficorgan = new TrafficOrganization();
            $trafficorgan->traffic_id = $request->traffic_id;
            $trafficorgan->organization_id = $id;
            $trafficorgan->date_from = $request->date_from;
            $trafficorgan->date_to = $request->date_to;
            $trafficorgan->price = $traffic->price;
            $trafficorgan->comment = $request->comment ?? '';
            $trafficorgan->save();

            $organizations = Organization::find($id);
            $organizations->location = $traffic->sms_count;
            $organizations->date_traffic = $request->date_to;
            $organizations->save();
        } else {
            $trafficorgan = new TrafficOrganization();
            $trafficorgan->traffic_id = $request->traffic_id;
            $trafficorgan->organization_id = $id;
            $trafficorgan->date_from = $request->date_from;
            $trafficorgan->date_to = $request->date_to;
            $trafficorgan->price = $traffic->price;
            $trafficorgan->comment = $request->comment ?? '';
            $trafficorgan->save();

            $organizations = Organization::find($id);
            $organizations->location = 0;
            $organizations->traffic_id = $request->traffic_id;
            $organizations->balance = $organizations->balance + (-1 * $traffic->price);
            $organizations->sms_count = 0;
            $organizations->date_traffic = $request->date_to;
            $organizations->save();
        }

        return redirect()->back()->with('success', __('messages.new_traffic_added_successfully'));
    }

    public function edit_traffic_organization(Request $request, $id)
    {
        //dd($request->all());
        $traffic = Traffic::find($request->traffic_id);
        if ($traffic->status == 1) {

            $trafficorgan = TrafficOrganization::find($id);
            $tr = $trafficorgan->traffic_id;
            $trafficorgan->traffic_id = $request->traffic_id;
            $trafficorgan->date_to = $request->date_to;
            $trafficorgan->price = $traffic->price;
            $trafficorgan->comment = $request->comment ?? '';
            $trafficorgan->save();

            $tr_tr = Traffic::find($tr);
            $organizations = Organization::find($trafficorgan->organization_id);
            $organizations->balance = $organizations->balance + $tr_tr->price + (-1 * $traffic->price);
            $organizations->location = $traffic->sms_count;
            $organizations->date_traffic = $request->date_to;
            $organizations->save();
        } else {
            $trafficorgan = TrafficOrganization::find($id);
            $tr = $trafficorgan->traffic_id;
            $trafficorgan->traffic_id = $request->traffic_id;
            $trafficorgan->date_to = $request->date_to;
            $trafficorgan->price = $traffic->price;
            $trafficorgan->comment = $request->comment ?? '';
            $trafficorgan->save();

            $tr_tr = Traffic::find($tr);
            $organizations = Organization::find($trafficorgan->organization_id);
            $organizations->location = 0;
            $organizations->traffic_id = $request->traffic_id;
            $organizations->balance = $organizations->balance + $tr_tr->price + (-1 * $traffic->price);
            $organizations->date_traffic = $request->date_to;
            $organizations->save();
        }


        return redirect()->back()->with('success', __('messages.traffic_edited_successfully'));
    }

    public function delete_traffic_organ(Request $request)
    {
        try {

            TrafficOrganization::find($request->id)
                ->delete();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function client_app()
    {
        $photos = AdminPhotoSlider::all();
        $swiperphotos = SwiperPhoto::all();
        return view('client_app.index', [
            'photos' => $photos,
            'swiperphotos' => $swiperphotos
        ]);
    }

    public function client_app_carts_add(Request $request)
    {
        //  dd($request->all());

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('users/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/users/' . $fileName;

            $newPhoto = new AdminPhotoSlider();
            $newPhoto->name = $request->name ?? '';
            $newPhoto->lg_name = $request->lg_name ?? '';
            $newPhoto->photo = $filePath;
            $newPhoto->price = $request->price;
            $newPhoto->phone = $request->phone;
            $newPhoto->comment = $request->comment;
            $newPhoto->photo_url = url($filePath);
            $newPhoto->other = '';
            $newPhoto->status = 0;
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }

    public function client_app_carts_edit($id, Request $request)
    {

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('users/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/users/' . $fileName;

            $newPhoto = AdminPhotoSlider::find($id);
            $newPhoto->name = $request->name ?? '';
            $newPhoto->lg_name = $request->lg_name ?? '';
            $newPhoto->photo = $filePath;
            $newPhoto->price = $request->price;
            $newPhoto->phone = $request->phone;
            $newPhoto->comment = $request->comment;
            $newPhoto->photo_url = url($filePath);
            $newPhoto->other = '';
            $newPhoto->status = 0;
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }

    public function client_app_carts_delete($id, Request $request)
    {
        $newPhoto = AdminPhotoSlider::find($id)->delete();
        return redirect()->back()->with('msg', 1);
    }

    public function client_app_swiper_add(Request $request)
    {

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('swipers/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/swipers/' . $fileName;

            $newPhoto = new SwiperPhoto();
            $newPhoto->name = $request->name ?? '';
            $newPhoto->lg_name = $request->lg_name ?? '';
            $newPhoto->photo = $filePath;
            $newPhoto->price = $request->price;
            $newPhoto->phone = $request->phone;
            $newPhoto->comment = $request->comment;
            $newPhoto->photo_url = url($filePath);
            $newPhoto->other = '';
            $newPhoto->status = 0;
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }


    public function client_app_swiper_edit($id, Request $request)
    {

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('swipers/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/swipers/' . $fileName;

            $newPhoto = SwiperPhoto::find($id);
            $newPhoto->name = $request->name ?? '';
            $newPhoto->lg_name = $request->lg_name ?? '';
            $newPhoto->photo = $filePath;
            $newPhoto->price = $request->price;
            $newPhoto->phone = $request->phone;
            $newPhoto->comment = $request->comment;
            $newPhoto->photo_url = url($filePath);
            $newPhoto->other = '';
            $newPhoto->status = 0;
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }

    public function client_app_swiper_delete($id, Request $request)
    {
        $newPhoto = SwiperPhoto::find($id)->delete();
        return redirect()->back()->with('msg', 1);
    }


    public function admin_carts_api()
    {
        $photosNew = AdminPhotoSlider::all();

        return response()->json($photosNew, 200);
    }

    public function admin_swipers_api()
    {
        $photosNew = SwiperPhoto::all();

        return response()->json($photosNew, 200);
    }

    public function admin_orgswipers_api(Request $request)
    {
        $org = Client::find($request->client_id)->organization_id;

        $photosNew = OrganizationSwiper::where('organization_id', $org)->get();

        return response()->json($photosNew, 200);
    }

    public function organization_app()
    {
        $photos = OrganizationSwiper::all();
        $organizations = Organization::all();

        return view('client_app.org-index', [
            'photos' => $photos,
            'organizations' => $organizations
        ]);
    }

    public function organization_app_swiper_add(Request $request)
    {

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('organizations/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/organizations/' . $fileName;

            $newPhoto = new OrganizationSwiper();
            $newPhoto->organization_id = $request->organization_id;
            $newPhoto->name = $request->name ?? '';
            $newPhoto->lg_name = $request->lg_name ?? '';
            $newPhoto->photo = $filePath;
            $newPhoto->price = $request->price ?? '';
            $newPhoto->phone = $request->phone ?? '';
            $newPhoto->comment = $request->comment ?? '';
            $newPhoto->photo_url = url($filePath);
            $newPhoto->other = '';
            $newPhoto->status = 0;
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }


    public function organization_app_swiper_edit($id, Request $request)
    {

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('organizations/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/organizations/' . $fileName;

            $newPhoto = OrganizationSwiper::find($id);
            $newPhoto->organization_id = $request->organization_id;
            $newPhoto->name = $request->name ?? '';
            $newPhoto->lg_name = $request->lg_name ?? '';
            $newPhoto->photo = $filePath;
            $newPhoto->price = $request->price;
            $newPhoto->phone = $request->phone;
            $newPhoto->comment = $request->comment;
            $newPhoto->photo_url = url($filePath);
            $newPhoto->other = '';
            $newPhoto->status = 0;
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }

    public function organization_app_swiper_delete($id, Request $request)
    {
        $newPhoto = OrganizationSwiper::find($id)->delete();
        return redirect()->back()->with('msg', 1);
    }

    public function organization_app_cart()
    {
        $photos = CartPhoto::all();
        $carts = AdminPhotoSlider::all();
        return view('client_app.add_cart', [
            'photos' => $photos,
            'carts' => $carts
        ]);
    }

    public function admin_app_cart_add(Request $request)
    {

        if ($request->photo) {

            $fileName = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('carts/' . $fileName, File::get($request->photo));
            $file_name = $request->photo->getClientOriginalName();
            $file_type = $request->photo->getClientOriginalExtension();
            $filePath = 'storage/carts/' . $fileName;

            $newPhoto = new CartPhoto();
            $newPhoto->cart_id = $request->cart_id;
            $newPhoto->photo = $filePath;
            $newPhoto->photo_url = url($filePath);
            $newPhoto->save();

            return redirect()->back()->with('msg', 1);

        }
    }

    public function cart_photo(Request $request)
    {
        $pt = CartPhoto::where('cart_id', $request->cart_id)->get();

        return response()->json($pt, 200);
    }

    public function politica()
    {
        return view('politica');
    }
}