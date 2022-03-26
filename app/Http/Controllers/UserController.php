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
        $users = UserOrganization::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $x = 0;
        $y = [];
        foreach ($users as $user) {
            $x ++;
            $y[$x] = $user->user_id;
        }

        $data = User::whereIn('id',$y)->get();
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('users.index',[
            'data' => $data,
            'info_org' => $info_org
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function users_admin(Request $request)
    {
        $data = User::all();
        $org = [];

        foreach ($data as $dat) {
            $x = UserOrganization::where('user_id', $dat->id)->value('organization_id');
            if ($x != 0)
            {
                 $d = Organization::find($x);           
                $org[$dat->id] = $d->name;
            }
        }

        return view('users.index',[
            'data' => $data,
            'org'   => $org
        ]);
    }

    public function create()
    {
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('users.create',[
            'info_org' => $info_org
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);

        if($request->bosh == 'on') $user->givePermissionTo('bosh-menu');
        if($request->client == 'on') $user->givePermissionTo('clients');
        if($request->order == 'on') $user->givePermissionTo('orders');
        if($request->results == 'on') $user->givePermissionTo('results');
        if($request->sms == 'on') $user->givePermissionTo('smsmanager');
        if($request->regions == 'on') $user->givePermissionTo('regions');
        if($request->product == 'on') $user->givePermissionTo('products');
        if($request->sklad == 'on') $user->givePermissionTo('sklad');
        if($request->users == 'on') $user->givePermissionTo('users');

        $x = new UserOrganization();
        $x->organization_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $x->user_id = User::where('email',$request->email)->value('id');
        $x->save();

        return redirect()->route('users')
                        ->with('success','User created successfully');
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
        return view('users.show',compact('user'));
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

        for($i=1; $i<=10; $i++) {
            $p[$i] = '0';
        }

        foreach ($user->permissions as $per) {
            $p[$per->id] = $per->name;
        }
        $info_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $info_org = Organization::find($info_id);

        return view('users.edit',compact('user','p','info_org'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_permissions')->where('model_id',$id)->delete();
    
        if($request->bosh == 'on') $user->givePermissionTo('bosh-menu');
        if($request->client == 'on') $user->givePermissionTo('clients');
        if($request->order == 'on') $user->givePermissionTo('orders');
        if($request->results == 'on') $user->givePermissionTo('results');
        if($request->sms == 'on') $user->givePermissionTo('smsmanager');
        if($request->regions == 'on') $user->givePermissionTo('regions');
        if($request->product == 'on') $user->givePermissionTo('products');
        if($request->sklad == 'on') $user->givePermissionTo('sklad');
        if($request->users == 'on') $user->givePermissionTo('users');
    
        return redirect()->route('users')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users')
                        ->with('success','User deleted successfully');
    }
}