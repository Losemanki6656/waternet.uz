<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\UserOrganization;
use App\Models\Organization;
use DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('organization_id', auth()->user()->organization_id)->get();

        $roles = array(1 => 'Operator', 2 => 'Warehouse manager', 3 => 'Driver', 4 => 'Director');

        return view('users.index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function users_admin(Request $request)
    {
        $data = User::where('role', 4)->get();
        $org = [];

        foreach ($data as $dat) {
            $x = $dat->organization_id;
            if ($x != 0) {
                $d = Organization::find($x);
                $org[$dat->id] = $d->name;
            }
        }

        return view('users.index', [
            'data' => $data,
            'org' => $org
        ]);
    }

    public function create()
    {
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);
        $roles = array(1 => 'Operator', 2 => 'Warehouse manager', 3 => 'Driver', 4 => 'Director');

        return view('users.create', [
            'info_org' => $info_org,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organ = auth()->user()->organization_id;
        $count = Organization::find($organ);

        if ($count->users_count < $count->traffic->users_count) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password'
            ]);

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);

            if ($request->bosh == 'on')
                $user->givePermissionTo('bosh-menu');
            if ($request->client == 'on')
                $user->givePermissionTo('clients');
            if ($request->order == 'on')
                $user->givePermissionTo('orders');
            if ($request->results == 'on')
                $user->givePermissionTo('results');
            if ($request->sms == 'on')
                $user->givePermissionTo('smsmanager');
            if ($request->regions == 'on')
                $user->givePermissionTo('regions');
            if ($request->product == 'on')
                $user->givePermissionTo('products');
            if ($request->sklad == 'on')
                $user->givePermissionTo('sklad');
            if ($request->users == 'on')
                $user->givePermissionTo('users');

            $x = new UserOrganization();
            $x->organization_id = auth()->user()->organization_id;
            $x->user_id = User::where('email', $request->email)->value('id');
            $x->role = $request->role;
            $x->save();

            $count = Organization::find($organ);
            $count->users_count = $count->users_count + 1;
            $count->save();

            $user->organization_id = auth()->user()->organization_id;
            $user->role = $request->role;
            $user->save();

            return redirect()->route('users')
                ->with('success', __('messages.User_created_successfully'));
        } else
            return redirect()->route('users')
                ->with('error', __('messages.forbidden_traffic'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $p = [];

        for ($i = 1; $i <= 10; $i++) {
            $p[$i] = '0';
        }

        foreach ($user->permissions as $per) {
            $p[$per->id] = $per->name;
        }

        $users = User::where('id', '!=', $user->id)->where('organization_id', $user->organization_id)->get();

        $info_org = Organization::find($user->organization_id);

        $roles = array(1 => 'Operator', 2 => 'Warehouse manager', 3 => 'Driver', 4 => 'Director');

        return view('users.edit', compact('user', 'p', 'roles', 'users'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_permissions')->where('model_id', $id)->delete();

        if ($request->bosh == 'on')
            $user->givePermissionTo('bosh-menu');
        if ($request->client == 'on')
            $user->givePermissionTo('clients');
        if ($request->order == 'on')
            $user->givePermissionTo('orders');
        if ($request->results == 'on')
            $user->givePermissionTo('results');
        if ($request->sms == 'on')
            $user->givePermissionTo('smsmanager');
        if ($request->regions == 'on')
            $user->givePermissionTo('regions');
        if ($request->product == 'on')
            $user->givePermissionTo('products');
        if ($request->sklad == 'on')
            $user->givePermissionTo('sklad');
        if ($request->users == 'on')
            $user->givePermissionTo('users');

        $us = UserOrganization::where('user_id', $id)
            ->value('id');
        $x = UserOrganization::find($us);
        $x->role = $request->role;
        $x->save();

        $user->role = $request->role;
        $user->save();

        return redirect()->route('users')
            ->with('success', __('messages.User_updated_successfully'));
    }


    public function destroy()
    {
        $user = User::find(request('id'));

        $count = Organization::find($user->organization_id);
        $count->users_count = $count->users_count + 1;
        $count->save();

        $user->delete();

        return redirect()->route('users')
            ->with('success', __('messages.User_deleted_successfully'));
    }
}