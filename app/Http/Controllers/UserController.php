<?php

namespace App\Http\Controllers;

use App\Models\RateUser;
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
     * All permissions with metadata (name => [label, icon, color]).
     * Single source of truth — used in index, create, edit blades + store/update.
     */
    public const PERMISSIONS = [
        'bosh-menu'    => ['label' => 'Bosh menu',       'icon' => 'fas fa-home',         'color' => 'primary'],
        'clients'      => ['label' => 'Klientlar',        'icon' => 'fas fa-users',         'color' => 'info'],
        'orders'       => ['label' => 'Zakazlar',         'icon' => 'fas fa-shopping-cart', 'color' => 'warning'],
        'products'     => ['label' => 'Tovarlar',         'icon' => 'fas fa-box',           'color' => 'success'],
        'sklad'        => ['label' => 'Sklad',            'icon' => 'fas fa-warehouse',     'color' => 'secondary'],
        'users'        => ['label' => 'Xodimlar',         'icon' => 'fas fa-user-cog',      'color' => 'dark'],
        'regions'      => ['label' => 'Regionlar',        'icon' => 'fas fa-map-marker-alt','color' => 'danger'],
        'drivers-map'  => ['label' => 'Haydovchilar xaritasi', 'icon' => 'fas fa-map-marked-alt', 'color' => 'info'],
        'smsmanager'   => ['label' => 'SMS',              'icon' => 'fas fa-sms',           'color' => 'primary'],
        'results'      => ['label' => 'Hisobotlar',       'icon' => 'fas fa-chart-bar',     'color' => 'success'],
        'DriverMobile' => ['label' => 'Driver Mobile',    'icon' => 'fas fa-mobile-alt',    'color' => 'info'],
        'ClientExport' => ['label' => 'Client Export',    'icon' => 'fas fa-file-export',   'color' => 'warning'],
    ];

    public static function roles(): array
    {
        return [1 => 'Operator', 2 => 'Warehouse manager', 3 => 'Driver', 4 => 'Director'];
    }

    public function index(Request $request)
    {
        $users = User::query()
            ->where('status', true)
            ->where('organization_id', auth()->user()->organization_id)
            ->with('permissions')
            ->get();

        return view('users.index', [
            'users'       => $users,
            'roles'       => self::roles(),
            'permissions' => self::PERMISSIONS,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function users_admin(Request $request)
    {
        // $data = User::where('role', 4)->get();
        // $org = [];

        // foreach ($data as $dat) {
        //     $x = $dat->organization_id;
        //     if ($x != 0) {
        //         $d = Organization::find($x);
        //         $org[$dat->id] = $d->name;
        //     }
        // }

        $shops = Organization::get();
        $users = User::query()->where('status', true)
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when(request('org_id'), function ($query, $org_id) {
                $query->where('organization_id', $org_id);
            })
            ->with('organization')
            ->paginate(request('per_page', 8));

        return view('users.admin_users', [
            'users' => $users,
            'shops' => $shops
        ]);
    }

    public function create()
    {
        return view('users.create', [
            'info_org'    => Organization::find(auth()->user()->organization_id),
            'roles'       => self::roles(),
            'permissions' => self::PERMISSIONS,
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $organ = auth()->user()->organization_id;

        $usersCount = User::where('status', true)->where('organization_id', $organ)->count();
        $org        = Organization::with('traffic')->findOrFail($organ);

        if ($usersCount >= $org->traffic->users_count) {
            return redirect()->route('users')->with('error', __('messages.forbidden_traffic'));
        }

        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
        ]);

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'password'        => Hash::make($request->password),
            'organization_id' => $organ,
            'role'            => $request->role,
        ]);

        // Sync permissions — only allow known permission names
        $allowed = collect(self::PERMISSIONS)->keys()->toArray();
        $granted = collect($request->input('permissions', []))
            ->filter(fn($p) => in_array($p, $allowed))
            ->values()->toArray();
        $user->syncPermissions($granted);

        UserOrganization::create([
            'organization_id' => $organ,
            'user_id'         => $user->id,
            'role'            => $request->role,
        ]);

        $org->increment('users_count');

        return redirect()->route('users')->with('success', __('messages.User_created_successfully'));
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::with('permissions')->findOrFail($id);

        // Name-based set — blade uses hasPermissionTo() or in_array()
        $userPermissions = $user->permissions->pluck('name')->toArray();

        $teammates = User::where('id', '!=', $user->id)
            ->where('organization_id', $user->organization_id)
            ->where('status', true)
            ->get();

        return view('users.edit', [
            'user'            => $user,
            'userPermissions' => $userPermissions,
            'roles'           => self::roles(),
            'permissions'     => self::PERMISSIONS,
            'users'           => $teammates,
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
        ]);

        $user = User::findOrFail($id);
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();

        // Sync permissions safely — only allowed permission names accepted
        $allowed = collect(self::PERMISSIONS)->keys()->toArray();
        $granted = collect($request->input('permissions', []))
            ->filter(fn($p) => in_array($p, $allowed))
            ->values()->toArray();
        $user->syncPermissions($granted);

        // Update UserOrganization role
        UserOrganization::where('user_id', $id)->update(['role' => $request->role]);

        $redirect = ($request->input('from') === 'admin_users' || auth()->user()->id == 1)
            ? 'users_admin'
            : 'users';
        return redirect()->route($redirect)->with('success', __('messages.User_updated_successfully'));
    }


    // ── Own profile (read/update for the authenticated user) ─────────────
    public function profile()
    {
        $user            = auth()->user()->load('permissions');
        $userPermissions = $user->permissions->pluck('name')->toArray();

        return view('users.profile', [
            'user'            => $user,
            'userPermissions' => $userPermissions,
            'permissions'     => self::PERMISSIONS,
        ]);
    }

    public function update_profile(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        $this->validate($request, [
            'name'             => 'required|string|max:100',
            'phone'            => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'password'         => 'nullable|min:6|same:confirm-password',
        ]);

        $user->name    = $request->name;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        // Password change — verify current password first
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => __('messages.wrong_current_password') ?? 'Joriy parol noto\'g\'ri'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', __('messages.profile_updated_successfully') ?? 'Profil yangilandi');
    }

    public function destroy()
    {
        $user = User::find(request('id'));

        $count = Organization::find($user->organization_id);
        $count->users_count = $count->users_count - 1;
        $count->save();

        $user->status = false;
        $user->save();

        return redirect()->route('users')
            ->with('success', __('messages.User_deleted_successfully'));
    }

    public function rate_users(Request $request)
    {
        $users = RateUser::Filter()
            ->with(['client', 'user'])
            ->paginate(request('per_page', 10));

        $rateMax = RateUser::Filter()
            ->groupBy('user_id')
            ->select([DB::raw('AVG(rate) as rateMax'), 'user_id'])
            ->with(['user'])
            ->orderBy('rateMax', 'desc')
            ->first();

        $rateMin = RateUser::Filter()
            ->groupBy('user_id')
            ->select([DB::raw('AVG(rate) as rateMax'), 'user_id'])
            ->with(['user'])
            ->orderBy('rateMax', 'asc')
            ->first();

        $clientMax = RateUser::Filter()
            ->select('client_id', DB::raw('count(*) as total'))
            ->groupBy('client_id')
            ->orderBy('total', 'desc')
            ->with('client')
            ->first();

        return view('rate_users.rate_users', [
            'users' => $users,
            'rateMax' => $rateMax,
            'rateMin' => $rateMin,
            'clientMax' => $clientMax
        ]);
    }
}
