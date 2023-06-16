<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use App\Models\UserOrganization;
use App\Models\RegionUser;
use App\Models\Sity;
use App\Models\client;
use App\Models\Area;
use App\Models\Organization;

class SettingController extends Controller
{
    public function setting1()
    {

        $users = User::get();

        foreach ( $users as $user) {
            $userOrg = UserOrganization::where('user_id', $user->id)->first();
            if($userOrg) {
                $user->organization_id = $userOrg->organization_id;
                $user->role = $userOrg->role;
            }

            $regionUser = RegionUser::where('user_id', $user->id)->first();
            if($regionUser) {
                $user->areas = $regionUser->areas;
            }

            $user->save();
        }
        
        dd('success');
        
    }

    public function setting2()
    {

        $cities = Area::get();

        foreach($cities as $city)
        {
            $org = Organization::where('id', $city->organization_id)->count();
            $reg = Sity::where('id', $city->city_id)->count();

            if(!$org || !$reg) {
                $city->delete();
            }
        }
        
        dd('success');
        
    }

    public function setting3()
    {

        $cities = Sity::get();

        foreach($cities as $city)
        {
            $org = Organization::where('id', $city->organization_id)->count();

            if(!$org) {
                $city->delete();
            }
        }
        
        dd('success');
        
    }

    public function setting4()
    {

        $clients = Client::get();

        $x = 0;
        foreach($clients as $client)
        {
            $org = Organization::where('id', $client->organization_id)->count();
            $reg = Sity::where('id', $client->city_id)->count();
            $area = Area::where('id', $client->area_id)->count();

            if(!$org || !$reg || !$area) {
                $client->delete();
                $x ++;
            }
        }
        
        dd('success', $x);
        
    }

}
