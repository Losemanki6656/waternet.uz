<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sms;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\UserOrganization;
use App\Models\RegionUser;
use App\Models\Sity;
use App\Models\Client;
use App\Models\Area;
use App\Models\Organization;

class SettingController extends Controller
{
    public function setting1()
    {

        $users = User::get();

        foreach ($users as $user) {
            $userOrg = UserOrganization::where('user_id', $user->id)->first();
            if ($userOrg) {
                $user->organization_id = $userOrg->organization_id;
                $user->role = $userOrg->role;
            }

            $regionUser = RegionUser::where('user_id', $user->id)->first();
            if ($regionUser) {
                $user->areas = $regionUser->areas;
            }

            $user->save();
        }

        dd('success');

    }

    public function setting2()
    {

        $cities = Area::get();

        foreach ($cities as $city) {
            $org = Organization::where('id', $city->organization_id)->count();

            $clients = Client::where('area_id', $city->id)->count();

            if (!$org && !$clients) {
                $reg = Sity::where('id', $city->city_id)->count();
                if (!$reg)
                    $city->delete();
            }
        }

        dd('success');

    }

    public function setting3()
    {

        $cities = Sity::get();

        foreach ($cities as $city) {
            $org = Organization::where('id', $city->organization_id)->count();

            if (!$org) {
                $city->delete();
            }
        }

        dd('success');

    }

    public function setting4()
    {

        $clients = Client::get();

        $x = 0;
        foreach ($clients as $client) {
            $org = Organization::where('id', $client->organization_id)->count();
            $reg = Sity::where('id', $client->city_id)->count();
            $area = Area::where('id', $client->area_id)->count();

            if (!$org) {
                if (!$reg || !$area) {
                    $client->delete();
                    $x++;
                }
            }
        }

        dd('success', $x);

    }

    public function setting5()
    {

        set_time_limit(300);

        $orders = Order::get();

        $a = [];
        $x = 0;
        foreach ($orders as $order) {

            $organ = Organization::where('id', $order->organization_id)->count();
            $city = Sity::where('id', $order->city_id)->count();
            $area = Area::where('id', $order->area_id)->count();
            $client = Client::where('id', $order->client_id)->count();
            $product = Product::where('id', $order->product_id)->count();
            $user = User::where('id', $order->user_id)->count();

            if (!$organ || !$city || !$area || !$client || !$product || !$user) {
                $x++;
                $a[] = $order->id;
            }

        }

        Order::whereIn('id', $a)->delete();

        dd($x);

    }

    public function setting6()
    {

        set_time_limit(300);

        $orders = Sms::get();

        $a = [];
        $x = 0;
        foreach ($orders as $order) {

            $organ = Organization::where('id', $order->organization_id)->count();
            $city = Sity::where('id', $order->city_id)->count();
            $area = Area::where('id', $order->area_id)->count();
            $client = Client::where('id', $order->client_id)->count();
            $user = User::where('id', $order->user_id)->count();

            if (!$organ || !$city || !$area || !$client || !$user) {
                $x++;
                $a[] = $order->id;
            }

        }

        Sms::whereIn('id', $a)->delete();

        dd($x);

    }

}