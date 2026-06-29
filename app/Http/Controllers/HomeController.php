<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Exports\ResultsExport;
use App\Models\ActiveTraffic;
use App\Models\Area;
use App\Models\Client;
use App\Models\ClientChat;
use App\Models\ClientContainer;
use App\Models\ClientPrices;
use App\Models\EntryContainer;
use App\Models\Order;
use App\Models\Organization;
use App\Models\Product;
use App\Models\RateUser;
use App\Models\Sity;
use App\Models\SuccessOrders;
use App\Models\TakeProduct;
use App\Models\User;
use App\Models\UserOrganization;
use App\Services\ClientService;
use App\Services\DashboardService;
use App\Services\OrderService;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function __construct(
        private readonly ClientService   $clientService,
        private readonly OrderService    $orderService,
        private readonly DashboardService $dashboardService,
    ) {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return Renderable
     */


    public function dashboard(Request $request)
    {
        $orgId = auth()->user()->organization_id;

        // Parse ?date=YYYY-MM-DD, default to today
        $date = $request->filled('date')
            ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfDay()
            : today();

        $stats     = $this->dashboardService->getStats($orgId, $date);
        $tableUser = $this->dashboardService->getUserTable($orgId, $date);

        return view('dashboard', array_merge($stats, [
            'tableUser'    => $tableUser,
            'selectedDate' => $date,
            'isToday'      => $date->isToday(),
        ]));
    }

    public function user_info()
    {
        $organization = Organization::with('traffic')->find(auth()->user()->organization_id);

        $a[] = [
            'clientCount' => Client::where('organization_id', auth()->user()->organization_id)->where('status', true)->count(),
            'clientCountTraffic' => $organization->traffic->clients_count ?? 0,
            'smsCount' => $organization->sms_count,
            'smsCountTraffic' => $organization->traffic->sms_count,
            'productsCount' => Product::where('organization_id', auth()->user()->organization_id)->count(),
            'productsCountTraffic' => $organization->traffic->products_count,
            'usersCount' => User::query()->where('status', true)
                ->where('organization_id', auth()->user()->organization_id)->count(),
            'usersCountTraffic' => $organization->traffic->users_count,
            'balance' => $organization->balance,
            'date_traffic' => $organization->date_traffic,
        ];

        return response()->json([
            'data' => $a[0]
        ]);
    }

    public function index()
    {
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        if (Auth::user()->id != 1)
            if ($info_org->date_traffic < now())
                return view('error');

        return view('home', [
            'info_org' => $info_org
        ]);
    }

    public function statistics()
    {
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        $usersArr = UserOrganization::where('organization_id', $info_id)->where('role', 3)->pluck('user_id')->toArray();
        $dusers = User::whereIn('id', $usersArr)->get();

        $p1roducts = [];
        $p2roducts = [];
        $p3roducts = [];
        foreach ($dusers as $auser) {

            $p1roducts[$auser->id] = TakeProduct::whereDate('created_at', '=', now())
                ->where('received_id', $auser->id)
                ->sum('product_count');

            $p2roducts[$auser->id] = SuccessOrders::whereDate('created_at', '=', now())
                ->where('user_id', $auser->id)
                ->whereIn('order_status', [1, 2])->sum('count');

            $p3roducts[$auser->id] = EntryContainer::whereDate('created_at', '=', now())
                ->where('user_id', $auser->id)
                ->sum('product_count');

        }
        // dd($takeproducts, $soldproducts);

        if ($info_org->date_traffic < now())
            return view('error');

        if (Auth::user()->id != 1) {
            $maxsum = 0;
            $x = 1;
            while ($x < 8) {
                $data2 = now()->subDays($x - 1);

                $solds = SuccessOrders::where('organization_id', $info_id)
                    ->whereDate('created_at', '=', $data2)
                    ->whereIn('order_status', [1, 2])
                    ->get();

                $solds2 = ClientPrices::where('organization_id', $info_id)
                    ->whereDate('created_at', '=', $data2)
                    ->get();

                $order = Order::where('organization_id', $info_id)
                    ->whereDate('created_at', '=', $data2)
                    ->sum('product_count');
                $takeproduct = TakeProduct::where('organization_id', $info_id)
                    ->whereDate('created_at', '=', $data2)
                    ->sum('product_count');

                $entrycon = SuccessOrders::
                where('organization_id', $info_id)
                    ->whereDate('created_at', '=', $data2)
                    ->sum('container');

                $takecon = EntryContainer::
                where('organization_id', $info_id)
                    ->whereDate('created_at', '=', $data2)
                    ->sum('product_count');

                $soldproducts = $solds->sum('count');
                $soldsumm = 0;
                $amount = 0;
                $payment1 = 0;
                $payment2 = 0;
                $payment3 = 0;

                foreach ($solds as $sold) {

                    if ($sold->count * $sold->price >= $sold->amount)
                        $soldsumm = $soldsumm + $sold->count * $sold->price;
                    else
                        $soldsumm = $soldsumm + $sold->amount;

                    if ($sold->price_sold < 0)
                        $amount = $amount + $sold->price_sold;

                }

                foreach ($solds2 as $sold) {
                    if ($sold->status == 1)
                        $soldsumm = $soldsumm + $sold->amount;

                    if ($sold->payment == 1)
                        $payment1 = $payment1 + $sold->amount;
                    if ($sold->payment == 2)
                        $payment2 = $payment2 + $sold->amount;
                    if ($sold->payment == 3)
                        $payment3 = $payment3 + $sold->amount;
                }

                if ($x == 1) {
                    $y = $payment1 + $payment2;
                    $z = $soldsumm;
                }
                if ($soldsumm > $maxsum)
                    $maxsum = $soldsumm;
                $u[] = $soldsumm;
                $q[] = $payment1;
                $q2[] = $payment2;
                $q3[] = $payment3;

                $zakasoldi[] = $order;
                $idisholdi[] = $entrycon;
                $idishqaytardi[] = $takecon;
                $tovaroldi[] = $takeproduct;
                $tovarsotdi[] = $soldproducts;

                $q4[] = (-1) * $amount;
                $sana[] = $data2->format('Y-m-d');

                $x++;
            }
            $series = [
                [
                    'name' => 'Umumiy daromad',
                    'data' => $u
                ],
                [
                    'name' => 'Naqd pul',
                    'data' => $q
                ],
                [
                    'name' => 'Plastik',
                    'data' => $q2
                ],
                [
                    'name' => "Pul ko'chirish",
                    'data' => $q3
                ],
                [
                    'name' => 'Qarzdorlik',
                    'data' => $q4
                ]

            ];
            $series1 = [
                [
                    'name' => 'Zakaz oldi',
                    'data' => $zakasoldi
                ],
                [
                    'name' => 'Tovar oldi',
                    'data' => $tovaroldi
                ],
                [
                    'name' => 'Tovar sotdi',
                    'data' => $tovarsotdi
                ],
                [
                    'name' => "Idish oldi",
                    'data' => $idisholdi
                ],
                [
                    'name' => 'Idish qaytardi',
                    'data' => $idishqaytardi
                ]

            ];
            //dd($series1);
            $categories = $sana;

            $users = UserOrganization::where('organization_id', $info_id)->count();
            $dolg = Client::where('organization_id', $info_id)->where('balance', '<', '0')->sum('balance');
            $pered = Client::where('organization_id', $info_id)->where('balance', '>', '0')->sum('balance');
            $clients = Client::where('organization_id', $info_id)->get()->count();
            $lastclients = Client::where('organization_id', $info_id)->whereMonth('created_at', Carbon::now()->month)->get()->count();
            $products = Product::where('organization_id', $info_id)->get();

            return view('statistics', [
                'users' => $users,
                'series' => $series,
                'series1' => $series1,
                'categories' => $categories,
                'info_org' => $info_org,
                'dolg' => $dolg,
                'pered' => $pered,
                'soldsumm' => $z,
                'x' => $y,
                'maxsum' => $maxsum,
                'clients' => $clients,
                'lastclients' => $lastclients,
                'products' => $products,
                'p3roducts' => $p3roducts,
                'p2roducts' => $p2roducts,
                'p1roducts' => $p1roducts,
                'info_users' => $dusers
            ]);
        } else
            return redirect()->route('organizations');
    }


    public function active_traffics(Request $request)
    {
        $i = 0;
        $a = [];
        if ($request->tras)
            foreach ($request->tras as $key => $value) {
                $i++;
                $a[$i] = $key;
            }
        if ($request->tras2)
            foreach ($request->tras2 as $key => $value) {
                $i++;
                $a[$i] = $key;
            }
        $x = ActiveTraffic::find(1);
        $x->string1 = implode(',', $a);
        $x->save();

        return redirect()->back()->with('msg', 'ertraf');
    }

    public function clients(Request $request)
    {
        $organ = auth()->user()->organization_id;

        // Single unified query (fixes original bug where city/area filters were skipped during search)
        $query = Client::query()
            ->where('organization_id', $organ)
            ->when($request->input('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->orWhere('fullname', 'like', '%' . $search . '%')
                      ->orWhere('phone',    'like', '%' . $search . '%')
                      ->orWhere('address',  'like', '%' . $search . '%');
                });
            })
            ->when($request->input('city_id'), fn($q, $v) => $q->where('city_id', $v))
            ->when($request->input('area_id'), fn($q, $v) => $q->where('area_id', $v))
            ->with(['city', 'area', 'orders'])
            ->orderBy($request->input('filtr', 'activated_at'), 'DESC');

        $sities   = Sity::where('organization_id', $organ)->orderBy('sort')->get();
        $areas    = Area::where('city_id', $request->input('city_id', 0))->orderBy('sort')->get();
        $products = Product::where('organization_id', $organ)->get();

        if ($request->ajax()) {
            $perPage = (int) $request->input('paginate_select', session('per_page', 10));
            session(['per_page' => $perPage]);
            $page    = (int) $request->input('page', 1);
            $clients = $query->paginate($perPage, ['*'], 'page', $page);

            $tableHtml = view('include_tables.clients_table', [
                'clients'  => $clients,
                'products' => $products,
                'sities'   => $sities,
            ])->render();

            $paginationHtml = $clients->total() > 10
                ? $clients->onEachSide(1)->withQueryString()->links()->toHtml()
                : '';

            return response()->json([
                'table'      => $tableHtml,
                'pagination' => $paginationHtml,
                'total'      => $clients->total(),
                'perPage'    => $clients->perPage(),
            ]);
        }

        // Non-AJAX: original SSR behavior
        $page = $request->input('page', session('clients_page', 1));
        session(['clients_page' => $page]);

        if ($request->input('paginate_select')) {
            session(['per_page' => $request->input('paginate_select')]);
        }

        return view('clients.v2_clients', [
            'clients'  => $query->paginate(session('per_page', 10), ['*'], 'page', $page),
            'sities'   => $sities,
            'areas'    => $areas,
            'products' => $products,
        ]);
    }

    public function update_per_page()
    {
        session([
            'per_page' => request('paginate_select')
        ]);

        return redirect()->route('clients');
    }

    public function export_clients(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('ClientExport')) {
            abort(403, __('messages.forbidden') ?? 'Ruxsat yo\'q');
        }

        $organ = auth()->user()->organization_id;

        $clients = Client::query()
            ->where('organization_id', $organ)
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('fullname', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%');
                });
            })
            ->when(request('city_id'), function ($query, $city_id) {
                $query->where('city_id', $city_id);
            })
            ->when(request('area_id'), function ($query, $area_id) {
                $query->where('area_id', $area_id);
            })
            ->with([
                'city',
                'area'
            ])
            ->orderBy(request('filtr', 'activated_at'), 'DESC')->get();

        $a = [];
        $x = 0;
        $b = [];
        foreach ($clients as $item) {
            $x++;
            $a[] = [
                'num' => $x,
                'fullname' => $item->fullname,
                'phone' => $item->phone . "\n" . $item->phone2,
                'region' => $item->RegionAddress(),
                'address' => $item->Address(),
                'balance' => $item->balance,
                'container' => $item->container,
                'active' => $item->activated_at->format('Y-m-d')
            ];

            $days = (int) abs($item->activated_at->diffInDays());
            if ($days > 14)
                $b[] = 'FFC7CE';
            elseif ($days >= 7)
                $b[] = 'FFEB9C';
            else
                $b[] = 'C6EFCE';
        }
        $x += 3;
        $organization = auth()->user()->organization;
        return Excel::download(new ClientsExport($a, $organization, $x, $b), 'Clients.xlsx');

    }


    public function add_client_page()
    {
        $organ = auth()->user()->organization_id;
        $count = Organization::find($organ);

        if ($count->clients_count < $count->traffic->clients_count) {
            $clients = Client::where('organization_id', auth()->user()->organization_id)->with('city')->with('user')->get();

            $sities = Sity::where('organization_id', $organ)->get();
            $areas = Area::where('city_id', request('city_id', 0))->get();

            $info_org = Organization::find($organ);

            return view('clients.addclient', [
                'clients' => $clients,
                'sities' => $sities,
                'areas' => $areas,
                'info_org' => $info_org
            ]);
        } else
            return redirect()->back()->with('msg', 'ertraf');


    }

    public function location()
    {
        return view('clients.location');
    }

    public function location_id($id)
    {
        return view('clients.location_id', [
            'id_client' => $id
        ]);
    }

    public function add_client(Request $request): RedirectResponse
    {
        try {
            $userClients    = Client::where('organization_id', auth()->user()->organization_id)->where('status', true)->count();
            $trafficClients = auth()->user()->organization->traffic->clients_count;

            if ($userClients >= $trafficClients) {
                return redirect()->back()->with('warning', __('messages.clients_count_traffic'));
            }

            $request->validate(['login' => 'required|unique:clients|max:255']);

            $this->clientService->create(
                $request->all(),
                auth()->user()->organization_id,
                auth()->id(),
            );

            return redirect()->back()->with('success', __('messages.new_customer_created_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function client_edit(Request $request, $id)
    {
        try {
            $this->clientService->update(Client::findOrFail($id), $request->all());

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => __('messages.client_info_updated')]);
            }
            return redirect()->back()->with('success', __('messages.client_info_updated'));
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_client(Request $request): JsonResponse
    {
        try {

            $this->clientService->deactivate($request->id, auth()->user()->organization_id);

            return response()->json(['message' => 'success']);

        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }


    }

    public function add_location(Request $request): JsonResponse
    {
        $client = Client::find($request->client_id);
        $client->location = $request->lat . "," . $request->lng;
        $client->save();

        return response()->json(['message' => 'success']);
    }

    public function add_order_check(Request $request)
    {
        try {
            $this->orderService->createBulkOrders(
                array_keys($request->checkbox),
                auth()->user()->organization_id,
                auth()->id(),
                $request->only(['product_id', 'count', 'sena', 'izoh']),
            );

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => __('messages.order_received_successfully')]);
            }
            return redirect()->back()->with('success', __('messages.order_received_successfully'));
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function add_order($id, Request $request)
    {
        try {
            $order = $this->orderService->createOrder(
                $id,
                auth()->user()->organization_id,
                auth()->id(),
                $request->only(['product_id', 'count', 'sena', 'izoh']),
            );

            if ($order === null) {
                return response()->json(['success' => false, 'message' => __('messages.this_customer_has_an_order')]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => __('messages.order_received_successfully')]);
            }
            return redirect()->back()->with('success', __('messages.order_received_successfully'));
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_location(Request $request)
    {
        try {
            $client = Client::findOrFail($request->client_id);
            $client->location = $request->location ?? '';
            $client->save();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => __('messages.location_updated_successfully')]);
            }

            return redirect()->back()->with('success', __('messages.location_updated_successfully'));
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_Order(): JsonResponse
    {
        try {

            Order::find(request('id'))->delete();

            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function search_areas(): JsonResponse
    {
        $data = Area::where('city_id', request('region_id', 0))->where('status', true)->get();

        return response()->json($data);
    }

    public function add_region(Request $request): RedirectResponse
    {
        try {

            $sity = new Sity();
            $sity->organization_id = auth()->user()->organization_id;
            $sity->name = $request->region_name;
            $sity->save();

            return redirect()->back()->with('success', __('messages.region_added_successfully'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    public function add_city(Request $request): RedirectResponse
    {
        try {

            $sity = new Area();
            $sity->organization_id = auth()->user()->organization_id;
            $sity->city_id = $request->sity_id;
            $sity->name = $request->area_name;
            $sity->save();

            return redirect()->back()->with('success', __('messages.city_added_successfully'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function orders(Request $request)
    {
        $organ = auth()->user()->organization_id;

        $query = Order::query()
            ->when($request->input('client_id'), fn($q, $v) => $q->where('client_id', $v))
            ->where('status', 0)
            ->where('organization_id', $organ)
            ->has('client')
            ->with(['product', 'user', 'client.city', 'client.area'])
            ->when($request->input('search'), function ($q, $search) {
                $q->whereHas('client', function ($q) use ($search) {
                    $q->where('fullname', 'like', '%' . $search . '%')
                      ->orWhere('phone',    'like', '%' . $search . '%')
                      ->orWhere('address',  'like', '%' . $search . '%');
                });
            })
            ->when($request->input('city_id'), fn($q, $v) => $q->where('city_id', $v))
            ->when($request->input('area_id'), fn($q, $v) => $q->where('area_id', $v))
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'asc');

        $sities   = Sity::where('organization_id', $organ)->get();
        $areas    = Area::where('city_id', $request->input('city_id', 0))->get();
        $products = Product::where('organization_id', $organ)->get();

        if ($request->ajax()) {
            $perPage   = (int) $request->input('paginate_select', session('orders_per_page', 10));
            session(['orders_per_page' => $perPage]);
            $page      = (int) $request->input('page', 1);
            $summOrder = $query->sum('product_count');
            $orders    = $query->paginate($perPage, ['*'], 'page', $page);

            $tableHtml = view('include_tables.orders_table', [
                'orders'   => $orders,
                'products' => $products,
            ])->render();

            $paginationHtml = $orders->total() > $perPage
                ? $orders->onEachSide(1)->withQueryString()->links()->toHtml()
                : '';

            return response()->json([
                'table'      => $tableHtml,
                'pagination' => $paginationHtml,
                'total'      => $orders->total(),
                'perPage'    => $orders->perPage(),
                'summOrder'  => $summOrder,
            ]);
        }

        $summOrder = $query->sum('product_count');
        $orders    = $query->paginate(session('orders_per_page', 10));

        return view('clients.orders', [
            'orders'     => $orders,
            'sities'     => $sities,
            'areas'      => $areas,
            'products'   => $products,
            'summ_order' => $summOrder,
        ]);
    }

    public function orders_sortable(Request $request): JsonResponse
    {

        $tasks = Order::where('organization_id', auth()->user()->organization_id)->get();

        foreach ($tasks as $task) {
            $task->timestamps = false;
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['sort' => $order['position']]);
                }
            }
        }
        return response()->json([
            'message' => __('messages.order_sortabled_successfully')
        ], 200);
    }

    public function region_sortable(Request $request): JsonResponse
    {

        $tasks = Sity::where('organization_id', auth()->user()->organization_id)->get();

        foreach ($tasks as $task) {
            $task->timestamps = false;
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['sort' => $order['position']]);
                }
            }
        }
        return response()->json([
            'message' => __('messages.order_sortabled_successfully')
        ], 200);
    }

    public function city_sortable(Request $request): JsonResponse
    {

        $tasks = Area::where('organization_id', auth()->user()->organization_id)->get();

        foreach ($tasks as $task) {
            $task->timestamps = false;
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['sort' => $order['position']]);
                }
            }
        }
        return response()->json([
            'message' => __('messages.order_sortabled_successfully')
        ], 200);
    }

    public function client_order_edit($id)
    {

        $orders = Order::where('client_id', $id)->where('status', 0)->with('client')->with('user')->with('product')->get();

        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        $products = Product::where('organization_id', $info_id)->get();

        return view('clients.order_edit', [
            'orders' => $orders,
            'info_org' => $info_org,
            'products' => $products
        ]);
    }

    public function order_edit(Request $request, $id)
    {
        try {
            $zakaz = Order::find($id);
            $zakaz->product_id       = $request->product_id;
            $zakaz->container_status = Product::findOrFail($request->product_id)->container_status;
            $zakaz->product_count    = $request->count;
            $zakaz->price            = $request->sena;
            $zakaz->comment          = $request->izoh ?? '';
            $zakaz->save();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => __('messages.order_updated_successfully')]);
            }
            return redirect()->back()->with('success', __('messages.order_updated_successfully'));
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function soldproducts($id)
    {
        $orgId = auth()->user()->organization_id;

        // Eager load all relationships in ONE query per table → eliminates N+1
        $client = Client::with(['city', 'area'])->findOrFail($id);

        $soldproducts = SuccessOrders::where('client_id', $id)
            ->whereIn('order_status', [1, 2])   // filter in DB, not in blade
            ->with(['product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $summ = $soldproducts->sum('amount');   // PHP collection sum – no extra query

        $clientprices = ClientPrices::where('client_id', $id)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $clientcontainer = ClientContainer::where('client_id', $id)
            ->with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $products = Product::where('organization_id', $orgId)->get();

        return view('clients.soldproducts', [
            'client'          => $client,
            'soldproducts'    => $soldproducts,
            'summ'            => $summ,
            'clientprices'    => $clientprices,
            'lastPrice'       => $clientprices->first(),   // most recent (desc order)
            'clientcontainer' => $clientcontainer,
            'lastContainer'   => $clientcontainer->first(),
            'products'        => $products,
        ]);
    }

    public function success_order_api(Request $request): JsonResponse
    {

        $id = $request->order_id;

        $orderinfo = Order::find($id);

        $client_info = Client::find($orderinfo->client_id);

        $x = $orderinfo->client_id;

        $y = $client_info->balance;

        if (SuccessOrders::where('created_at', now())->where('client_id', $orderinfo->client_id)->get()->count() > 0) {
            return response()->json(['message' => 'error', 429]);
        }

        if ($request->order_status == 1 || $request->order_status == 2) {

            $client_info->balance = $client_info->balance - ($request->sold_product_count * $request->sold_product_price) + $request->amount;

            if (Product::find($orderinfo->product_id)->container_status != 1) {
                $client_info->container = $client_info->container - $request->sold_product_count + $request->container - $request->invalid_container_count;
            }

            if ($request->sold_product_count) {
                $client_info->activated_at = now();
            }

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
        $successorder->address = $client_info->city->name . ',' . $client_info->area->name;
        $successorder->order_count = $orderinfo->product_count;
        $successorder->order_price = $orderinfo->price;
        $successorder->count = $request->sold_product_count;
        $successorder->price = $request->sold_product_price;
        $successorder->container = $request->container;
        $successorder->invalid_container_count = $request->invalid_container_count;
        $successorder->order_date = $orderinfo->created_at;
        $successorder->payment = $request->payment;

        if ($request->payment == 3) {
            if ($y >= $request->sold_product_count * $request->sold_product_price) {

                $successorder->amount = $request->sold_product_count * $request->sold_product_price;
                $successorder->client_price = $y;
                $successorder->price_sold = $request->sold_product_count * $request->sold_product_price;
            } else {
                if ($y >= 0) {
                    $successorder->amount = $y;
                    $successorder->client_price = $y;
                    $successorder->price_sold = $y - $request->sold_product_count * $request->sold_product_price;
                } else {
                    $successorder->amount = 0;
                    $successorder->client_price = $y;
                    $successorder->price_sold = (-1) * $request->sold_product_count * $request->sold_product_price;
                }
            }
        } else {
            $successorder->amount = $request->amount;
        }
        $successorder->client_price = $y;

        if ($y >= 0) {
            $successorder->price_sold = $y + $request->amount - $request->sold_product_count * $request->sold_product_price;
        } else {
            $successorder->price_sold = $request->amount - $request->sold_product_count * $request->sold_product_price;
        }

        $successorder->comment = $request->comment ?? '';

        $successorder->status = 0;

        $successorder->save();

        $or = Order::find($id);
        $or->status = 1;
        $or->save();

        $info_id = auth()->user()->organization_id;

        if ($request->order_status == 1 || $request->order_status == 2) {

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

            if (Product::find($orderinfo->product_id)->container_status != 1) {
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

        }

        $bot = ClientChat::where('id', $orderinfo->client_chat_id)->where('status', true)->first();
        if ($bot) {
            $newRate = new RateUser();
            $newRate->user_id = auth()->user()->id;
            $newRate->client_id = $orderinfo->client_id;
            $newRate->success_order_id = $successorder->id;
            $newRate->rate = 0;
            $newRate->save();

            $keyboard = array(
                "inline_keyboard" => array(
                    [
                        [
                            "text" => "1",
                            "callback_data" => "water_rate_1_" . $newRate->id
                        ],
                        [
                            "text" => "2",
                            "callback_data" => "water_rate_2_" . $newRate->id
                        ],
                        [
                            "text" => "3",
                            "callback_data" => "water_rate_3_" . $newRate->id
                        ],
                        [
                            "text" => "4",
                            "callback_data" => "water_rate_4_" . $newRate->id
                        ],
                        [
                            "text" => "5",
                            "callback_data" => "water_rate_5_" . $newRate->id
                        ]
                    ],
                    [
                        [
                            "text" => "6",
                            "callback_data" => "water_rate_6_" . $newRate->id
                        ],
                        [
                            "text" => "7",
                            "callback_data" => "water_rate_7_" . $newRate->id
                        ],
                        [
                            "text" => "8",
                            "callback_data" => "water_rate_8_" . $newRate->id
                        ],
                        [
                            "text" => "9",
                            "callback_data" => "water_rate_9_" . $newRate->id
                        ]
                    ]
                )
            );
            $keyboard = json_encode($keyboard);
            $text = "🥳 Спасибо за покупки! Получено - " . $successorder->amount . ", Доставлено - " . $successorder->count . ", Возврат тар - " .
                $successorder->container . ", Предоплата " . $client_info->balance . " 🥳";

            Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendMessage', [
                'chat_id' => $bot->chat_id,
                'text' => $text,
                "parse_mode" => "HTML"
            ]);

            $rate_text = "⭐️ Доставшик хизматини бахоланг ... ⭐️";
            Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendMessage', [
                'chat_id' => $bot->chat_id,
                'text' => $rate_text,
                "parse_mode" => "HTML",
                'reply_markup' => $keyboard
            ]);
        }

        $client_info = Client::find($orderinfo->client_id);

        return response()->json(['message' => 'success', 'balance' => $client_info->balance, 'container' => $client_info->container]);
    }


    public function results(Request $request)
    {
        [$date1, $date2] = $request->filled('date1')
            ? [Carbon::parse($request->date1)->toDateString(), Carbon::parse($request->date2)->toDateString()]
            : [now()->toDateString(), now()->toDateString()];

        $orgId   = auth()->user()->organization_id;
        $allUsers = User::where('organization_id', $orgId)->where('status', true)->get();

        // Filter to selected user if radio chosen, otherwise use all
        $users   = $request->filled('formRadios')
            ? $allUsers->where('id', (int) $request->formRadios)
            : $allUsers;

        $userIds = $users->pluck('id')->all();

        // --- 5 aggregated queries instead of 6×N ---

        // 1. Orders placed
        $orderTotals = Order::whereIn('user_id', $userIds)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->groupBy('user_id')
            ->selectRaw('user_id, SUM(product_count) as total')
            ->pluck('total', 'user_id');

        // 2. Products taken (received)
        $takeTotals = TakeProduct::whereIn('received_id', $userIds)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->groupBy('received_id')
            ->selectRaw('received_id, SUM(product_count) as total')
            ->pluck('total', 'received_id');

        // 3. SuccessOrders — sold count, revenue, debt, container returned
        $soldTotals = SuccessOrders::whereIn('user_id', $userIds)
            ->where('organization_id', $orgId)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->whereIn('order_status', [1, 2])
            ->groupBy('user_id')
            ->selectRaw("user_id,
                SUM(`count`) as sold_count,
                SUM(CASE WHEN `count` * price >= amount THEN `count` * price ELSE amount END) as sold_summ,
                SUM(CASE WHEN price_sold < 0 THEN ABS(price_sold) ELSE 0 END) as dolg_summ,
                SUM(container) as container_sum")
            ->get()
            ->keyBy('user_id');

        // 4. ClientPrices — cash/card/transfer payments + direct sales
        $priceTotals = ClientPrices::whereIn('user_id', $userIds)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->groupBy('user_id')
            ->selectRaw("user_id,
                SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) as sold_summ,
                SUM(CASE WHEN payment = 1 THEN amount ELSE 0 END) as payment1,
                SUM(CASE WHEN payment = 2 THEN amount ELSE 0 END) as payment2,
                SUM(CASE WHEN payment = 3 THEN amount ELSE 0 END) as payment3")
            ->get()
            ->keyBy('user_id');

        // 5. EntryContainer — containers collected
        $entryTotals = EntryContainer::whereIn('user_id', $userIds)
            ->where('organization_id', $orgId)
            ->whereDate('created_at', '>=', $date1)
            ->whereDate('created_at', '<=', $date2)
            ->groupBy('user_id')
            ->selectRaw('user_id, SUM(product_count) as total')
            ->pluck('total', 'user_id');

        // --- Colour palette for sidebar legend ---
        $arrayColors = ['success', 'info', 'primary', 'danger', 'dark', 'warning', 'secondary'];
        $color = [];
        foreach ($allUsers as $item) {
            $color[$item->id] = Arr::random($arrayColors);
        }

        // --- Build per-user arrays from aggregated results ---
        $order = $takeproduct = $soldproducts = $soldsumm = [];
        $entrycon = $takecon = $payment1 = $payment2 = $payment3 = $amount = $roles = [];
        $dataUser = [];

        foreach ($users as $user) {
            $uid = $user->id;
            $s   = $soldTotals->get($uid);
            $p   = $priceTotals->get($uid);

            $order[$uid]        = (int) ($orderTotals[$uid] ?? 0);
            $takeproduct[$uid]  = (int) ($takeTotals[$uid] ?? 0);
            $soldproducts[$uid] = (int) ($s->sold_count ?? 0);
            $entrycon[$uid]     = (int) ($s->container_sum ?? 0);
            $takecon[$uid]      = (int) ($entryTotals[$uid] ?? 0);
            $soldsumm[$uid]     = (float) ($s->sold_summ ?? 0) + (float) ($p->sold_summ ?? 0);
            $amount[$uid]       = (float) ($s->dolg_summ ?? 0);
            $payment1[$uid]     = (float) ($p->payment1 ?? 0);
            $payment2[$uid]     = (float) ($p->payment2 ?? 0);
            $payment3[$uid]     = (float) ($p->payment3 ?? 0);
            $roles[$uid]        = $user->roleName();

            $dataUser[] = [
                'name' => $user->name,
                'data' => [$order[$uid], $takeproduct[$uid], $soldproducts[$uid], $entrycon[$uid], $takecon[$uid]],
            ];
        }

        return view('results', [
            'roles'            => $roles,
            'data'             => $allUsers,
            'users'            => $users,
            'order'            => $order,
            'takeproduct'      => $takeproduct,
            'soldproducts'     => $soldproducts,
            'soldsumm'         => $soldsumm,
            'dolgsumm'         => array_sum($amount),
            'entrycon'         => $entrycon,
            'takecon'          => $takecon,
            'amount'           => $amount,
            'payment1'         => $payment1,
            'payment2'         => $payment2,
            'payment3'         => $payment3,
            'summorder'        => array_sum($order),
            'summtakeproduct'  => array_sum($takeproduct),
            'summsoldproducts' => array_sum($soldproducts),
            'summsoldsumm'     => array_sum($soldsumm),
            'summentrycon'     => array_sum($entrycon),
            'summpayment1'     => array_sum($payment1),
            'summpayment2'     => array_sum($payment2),
            'summpayment3'     => array_sum($payment3),
            'takesumm'         => array_sum($takecon),
            'otherSumm'        => 0,
            'color'            => $color,
            'dataUser'         => json_encode($dataUser),
            'categories'       => json_encode([
                __('messages.given_order'),
                __('messages.given_product'),
                __('messages.sold_product'),
                __('messages.given_container'),
                __('messages.returned_container'),
            ]),
        ]);
    }

    public function calendar(Request $request)
    {
        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }

        $arrayColors = [
            'success',
            // 'info',
            'primary',
            'danger',
            'dark',
            'warning',
            'secondary'
        ];

        $info_id = auth()->user()->organization_id;

        $data = User::where('organization_id', auth()->user()->organization_id)->get();

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
        $x = -1;

        foreach ($data as $user) {
            $order[$user->id] = Order::
            where('user_id', $user->id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->sum('product_count');
            $takeproduct[$user->id] = TakeProduct::whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('received_id', $user->id)
                ->sum('product_count');

            $solds = SuccessOrders::whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->whereIn('order_status', [1, 2])
                ->get();

            $solds2 = ClientPrices::whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->get();

            $soldproducts[$user->id] = $solds->sum('count');
            $roles[$user->id] = $user->roleName();
            $soldsumm[$user->id] = 0;
            $amount[$user->id] = 0;
            $payment1[$user->id] = 0;
            $payment2[$user->id] = 0;
            $payment3[$user->id] = 0;

            foreach ($solds as $sold) {

                if ($sold->count * $sold->price >= $sold->amount)
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->count * $sold->price;
                else
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->amount;

                if ($sold->price_sold < 0)
                    $amount[$user->id] = $amount[$user->id] + $sold->price_sold;

            }

            foreach ($solds2 as $sold) {
                if ($sold->status == 1)
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->amount;

                if ($sold->payment == 1)
                    $payment1[$user->id] = $payment1[$user->id] + $sold->amount;
                if ($sold->payment == 2)
                    $payment2[$user->id] = $payment2[$user->id] + $sold->amount;
                if ($sold->payment == 3)
                    $payment3[$user->id] = $payment3[$user->id] + $sold->amount;
            }
            $summorder = array_sum($order);
            $summtakeproduct = array_sum($takeproduct);
            $summsoldproducts = array_sum($soldproducts);
            $summsoldsumm = array_sum($soldsumm);

            $summpayment1 = array_sum($payment1);
            $summpayment2 = array_sum($payment2);
            $summpayment3 = array_sum($payment3);


            $entrycon[$user->id] = SuccessOrders::
            where('organization_id', $info_id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->sum('container');

            $takecon[$user->id] = EntryContainer::
            where('organization_id', $info_id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->sum('product_count');

            $summentrycon = array_sum($entrycon);
            $amount[$user->id] = (-1) * $amount[$user->id];
            $dolgsumm = array_sum($amount);
            $takesumm = array_sum($takecon);

            $x++;
            $color[$user->id] = $arrayColors[$x];
        }

        return view('calendar', [
            'roles' => $roles,
            'data' => $data,
            'order' => $order,
            'takeproduct' => $takeproduct,
            'soldproducts' => $soldproducts,
            'soldsumm' => $soldsumm,
            'dolgsumm' => $dolgsumm,
            'entrycon' => $entrycon,
            'takecon' => $takecon,
            'amount' => $amount,
            'payment1' => $payment1,
            'payment2' => $payment2,
            'payment3' => $payment3,
            'summorder' => $summorder,
            'summtakeproduct' => $summtakeproduct,
            'summsoldproducts' => $summsoldproducts,
            'summsoldsumm' => $summsoldsumm,
            'summentrycon' => $summentrycon,
            'summpayment1' => $summpayment1,
            'summpayment2' => $summpayment2,
            'summpayment3' => $summpayment3,
            'takesumm' => $takesumm,
            'color' => $color
        ]);

    }

    public function export_results(Request $request)
    {

        if ($request->date1 == null) {
            $date1 = now();
            $date2 = now();
        } else {

            $date1 = date('Y-m-d', strtotime($request->date1));
            $date2 = date('Y-m-d', strtotime($request->date2));
        }
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        $users = UserOrganization::where('organization_id', auth()->user()->organization_id)->get();
        $x = 0;
        $y = [];
        foreach ($users as $user) {
            $x++;
            $y[$x] = $user->user_id;
        }

        $data = User::whereIn('id', $y)->get();
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

        foreach ($data as $user) {
            $order[$user->id] = Order::
            where('user_id', $user->id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->sum('product_count');
            $takeproduct[$user->id] = TakeProduct::whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('received_id', $user->id)
                ->sum('product_count');
            $solds = SuccessOrders::whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->whereIn('order_status', [1, 2])->get();
            $solds2 = ClientPrices::whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)->get();

            $soldproducts[$user->id] = $solds->sum('count');
            $roles[$user->id] = UserOrganization::where('user_id', $user->id)->value('role');
            $soldsumm[$user->id] = 0;
            $amount[$user->id] = 0;
            $payment1[$user->id] = 0;
            $payment2[$user->id] = 0;
            $payment3[$user->id] = 0;

            foreach ($solds as $sold) {

                if ($sold->count * $sold->price >= $sold->amount)
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->count * $sold->price;
                else
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->amount;

                if ($sold->price_sold < 0)
                    $amount[$user->id] = $amount[$user->id] + $sold->price_sold;

            }

            foreach ($solds2 as $sold) {
                if ($sold->status == 1)
                    $soldsumm[$user->id] = $soldsumm[$user->id] + $sold->amount;

                if ($sold->payment == 1)
                    $payment1[$user->id] = $payment1[$user->id] + $sold->amount;
                if ($sold->payment == 2)
                    $payment2[$user->id] = $payment2[$user->id] + $sold->amount;
                if ($sold->payment == 3)
                    $payment3[$user->id] = $payment3[$user->id] + $sold->amount;
            }
            $summorder = array_sum($order);
            $summtakeproduct = array_sum($takeproduct);
            $summsoldproducts = array_sum($soldproducts);
            $summsoldsumm = array_sum($soldsumm);

            $summpayment1 = array_sum($payment1);
            $summpayment2 = array_sum($payment2);
            $summpayment3 = array_sum($payment3);


            $entrycon[$user->id] = SuccessOrders::
            where('organization_id', $info_id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->sum('container');

            $takecon[$user->id] = EntryContainer::
            where('organization_id', $info_id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at', '<=', $date2)
                ->where('user_id', $user->id)
                ->sum('product_count');

            $summentrycon = array_sum($entrycon);
            $amount[$user->id] = (-1) * $amount[$user->id];
            $dolgsumm = array_sum($amount);
            $takesumm = array_sum($takecon);
        }

        $a = [];
        $x = 0;
        foreach ($data as $user) {
            $x++;
            $a[] = [
                'num' => $x,
                'name' => $user->name,
                'role' => $user->roleName(),
                'order' => $order[$user->id],
                'takeproduct' => $takeproduct[$user->id],
                'soldproduct' => $soldproducts[$user->id],
                'soldsum' => $soldsumm[$user->id],
                'entrycon' => $entrycon[$user->id],
                'takecon' => $takecon[$user->id],
                'payment1' => $payment1[$user->id],
                'payment2' => $payment2[$user->id],
                'payment3' => $payment3[$user->id],
                'amount' => $amount[$user->id]
            ];
        }
        $x += 3;
        $organization = auth()->user()->organization;

        return Excel::download(
            new ResultsExport(
                $a,
                $summorder,
                $summtakeproduct,
                $summsoldproducts,
                $summsoldsumm,
                $summentrycon,
                $summpayment1,
                $summpayment2,
                $summpayment3,
                $takesumm,
                $dolgsumm,
                $organization,
                $x
            ),
            'Results.xlsx'
        );


    }

    public function success_order(Request $request, $id)
    {
        try {

            $orderinfo = Order::find($id);

            $client_info = Client::find($orderinfo->client_id);
            $x = $orderinfo->client_id;

            $y = $client_info->balance;

            if ($request->order_status == 1 || $request->order_status == 2) {

                $client_info->balance = $client_info->balance - ($request->product_count * $request->price) + $request->amount;

                if (Product::find($orderinfo->product_id)->container_status != 1)
                    $client_info->container = $client_info->container - $request->product_count + $request->container - $request->invalid_container_count;

                if ($request->product_count) {
                    $client_info->activated_at = now();
                }

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
            $successorder->address = $client_info->city->name . ',' . $client_info->area->name;
            $successorder->order_count = $orderinfo->product_count;
            $successorder->order_price = $orderinfo->price;
            $successorder->count = $request->product_count;
            $successorder->price = $request->price;

            $successorder->container = $request->container;
            $successorder->invalid_container_count = $request->invalid_container_count;

            $successorder->order_date = $orderinfo->created_at;

            $successorder->payment = $request->payment;

            if ($request->payment == 3)
                if ($y >= $request->product_count * $request->price) {

                    $successorder->amount = $request->product_count * $request->price;
                    $successorder->client_price = $y;
                    $successorder->price_sold = $request->product_count * $request->price;
                } else {
                    if ($y >= 0) {
                        $successorder->amount = $y;
                        $successorder->client_price = $y;
                        $successorder->price_sold = $y - $request->product_count * $request->price;
                    } else {
                        $successorder->amount = 0;
                        $successorder->client_price = $y;
                        $successorder->price_sold = (-1) * $request->product_count * $request->price;
                    }
                } else
                $successorder->amount = $request->amount;
            $successorder->client_price = $y;
            if ($y >= 0)
                $successorder->price_sold = $y + $request->amount - $request->product_count * $request->price;
            else
                $successorder->price_sold = $request->amount - $request->product_count * $request->price;

            $successorder->comment = $request->comment ?? '';

            $successorder->status = 0;

            $successorder->save();

            $or = Order::find($id);
            $or->status = 1;
            $or->save();

            $info_id = auth()->user()->organization_id;

            $bot = ClientChat::where('id', $orderinfo->client_chat_id)
                ->where('status', true)
                ->first();

            if ($bot) {
                $newRate = new RateUser();
                $newRate->user_id = auth()->user()->id;
                $newRate->client_id = $orderinfo->client_id;
                $newRate->success_order_id = $successorder->id;
                $newRate->rate = 0;
                $newRate->save();

                $keyboard = array(
                    "inline_keyboard" => array(
                        [
                            [
                                "text" => "1",
                                "callback_data" => "water_rate_1_" . $newRate->id
                            ],
                            [
                                "text" => "2",
                                "callback_data" => "water_rate_2_" . $newRate->id
                            ],
                            [
                                "text" => "3",
                                "callback_data" => "water_rate_3_" . $newRate->id
                            ],
                            [
                                "text" => "4",
                                "callback_data" => "water_rate_4_" . $newRate->id
                            ],
                            [
                                "text" => "5",
                                "callback_data" => "water_rate_5_" . $newRate->id
                            ]
                        ],
                        [
                            [
                                "text" => "6",
                                "callback_data" => "water_rate_6_" . $newRate->id
                            ],
                            [
                                "text" => "7",
                                "callback_data" => "water_rate_7_" . $newRate->id
                            ],
                            [
                                "text" => "8",
                                "callback_data" => "water_rate_8_" . $newRate->id
                            ],
                            [
                                "text" => "9",
                                "callback_data" => "water_rate_9_" . $newRate->id
                            ]
                        ]
                    )
                );
                $keyboard = json_encode($keyboard);
                $text = "🥳 Спасибо за покупки! Получено - " . $successorder->amount . ", Доставлено - " . $successorder->count . ", Возврат тар - " .
                    $successorder->container . ", Предоплата " . $client_info->balance . " 🥳";

                Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendMessage', [
                    'chat_id' => $bot->chat_id,
                    'text' => $text,
                    "parse_mode" => "HTML"
                ]);

                $rate_text = "⭐️ Доставшик хизматини бахоланг ... ⭐️";
                Http::post('https://api.telegram.org/bot6325632109:AAFqHouzLr-OB_ODDvPiDeLN8RJmiNJAP0w/sendMessage', [
                    'chat_id' => $bot->chat_id,
                    'text' => $rate_text,
                    "parse_mode" => "HTML",
                    'reply_markup' => $keyboard
                ]);
            }


            if ($request->order_status == 1 || $request->order_status == 2) {

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

                if (Product::find($orderinfo->product_id)->container_status != 1) {
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

            }

            return redirect()->route('status_client', [
                'id' => $successorder->id
            ])->with('success', __('messages.order_delivery_confirmated_successfully'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function status_client($id)
    {
        $client_id = SuccessOrders::find($id)->client_id;
        $client_info = Client::find($client_id);

        return view('clients.status_client', [
            'client_info' => $client_info,
            'order' => $id
        ]);
    }

    public function products()
    {
        $products = Product::where('organization_id', auth()->user()->organization_id)->get();
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        if ($info_org->date_traffic < now())
            return view('error');

        return view('products.products', [
            'products' => $products,
            'info_org' => $info_org
        ]);
    }

    public function add_product(Request $request)
    {

        try {

            $organ = auth()->user()->organization_id;
            $count = Organization::find($organ);

            if (Product::where('organization_id', $organ)->count() < $count->traffic->products_count) {
                if ($request->photo != null) {
                    $fileName = time() . '.' . $request->photo->extension();
                    $path = $request->photo->storeAs('products', $fileName);
                }

                $product = new Product();
                $product->organization_id = auth()->user()->organization_id;
                $product->name = $request->name;
                $product->container_status = $request->idish_status;
                $product->price = $request->sena;
                $product->product_count = $request->count;
                $product->container = 0;

                if ($request->photo != null) {
                    $product->photo = 'storage/products/' . $fileName;
                } else
                    $product->photo = '';

                $product->save();

                // $count = Organization::find($organ);
                // $count->products_count = $count->products_count + 1;
                // $count->save();

                return redirect()->back()->with('success', __('messages.product_updated_successfully'));

            } else
                return redirect()->back()->with('error', __('messages.it_is_not_possible_to_do_this'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    public function workers()
    {
        $workers = UserOrganization::where('organization_id', auth()->user()->organization_id)->with('users')->get();
        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        if ($info_org->date_traffic < now())
            return view('error');

        return view('workers', [
            'workers' => $workers,
            'info_org' => $info_org
        ]);
    }

    public function regions()
    {
        $regions = Sity::where('organization_id', auth()->user()->organization_id)->orderBy('sort', 'asc')->get();

        if (request('filter')) {
            $areas = Area::where('organization_id', auth()->user()->organization_id)
                ->withCount('clients')
                ->orderBy('clients_count', 'asc')
                ->get();
        } else {
            $areas = Area::where('organization_id', auth()->user()->organization_id)
                ->with('region')
                ->orderBy('sort', 'asc')
                ->get();
        }

        return view('regions', [
            'regions' => $regions,
            'areas' => $areas
        ]);
    }

    public function cities(Request $request)
    {
        $regions = Sity::where('organization_id', auth()->user()->organization_id)->get();
        if ($request->filter) {
            $areas = Area::where('organization_id', auth()->user()->organization_id)
                ->withCount('clients')
                ->orderBy('clients_count', 'asc')
                ->get();
        } else {
            $areas = Area::where('organization_id', auth()->user()->organization_id)
                ->with('region')
                ->orderBy('city_id', 'asc')
                ->get();
        }

        $info_id = auth()->user()->organization_id;
        $info_org = Organization::find($info_id);

        return view('cities', [
            'regions' => $regions,
            'areas' => $areas,
            'info_org' => $info_org
        ]);
    }

    public function edit_region(Request $request, $id)
    {
        try {

            $region = Sity::find($id);
            $region->name = $request->region_name;
            $region->save();

            return redirect()->back()->with('success', __('messages.region_updated_successfully'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function delete_region()
    {
        try {

            Sity::find(request('id'))->update([
                'status' => false
            ]);

            Area::where('city_id', request('id'))->update([
                'status' => false
            ]);

            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function edit_city(Request $request, $id)
    {
        try {

            $sity = Area::find($id);
            $sity->city_id = $request->sity_id;
            $sity->name = $request->area_name;
            $sity->save();

            Client::where('area_id', $id)->update([
                'city_id' => $request->sity_id
            ]);

            Order::where('area_id', $id)->update([
                'city_id' => $request->sity_id
            ]);

            return redirect()->back()->with('success', __('messages.city_updated_successfully'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_city()
    {
        try {

            Area::find(request('id'))->update([
                'status' => false
            ]);

            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function driver_regions()
    {
        $user = auth()->user();

        // Admin assigns the driver's coverage via users.areas (CSV of area ids).
        // Show ONLY the sities that contain assigned areas, each with ONLY the
        // assigned areas — not the whole organization.
        if (!$user->areas) {
            return response()->json([]);
        }

        $assigned = array_map('intval', array_filter(explode(',', $user->areas), 'strlen'));

        $sities = Sity::where('organization_id', $user->organization_id)
            ->with(['areas' => function ($q) use ($assigned) {
                $q->whereIn('id', $assigned);
            }])
            ->get()
            ->filter(fn($sity) => $sity->areas->isNotEmpty())
            ->values();

        return response()->json($sities);
    }

    public function areas(Request $request)
    {
        $user = auth()->user();

        $query = Area::where('organization_id', $user->organization_id)
            ->where('city_id', $request->region_id)
            ->with(['region']);

        // Restrict to the driver's assigned areas only.
        if ($user->areas) {
            $assigned = array_map('intval', array_filter(explode(',', $user->areas), 'strlen'));
            $query->whereIn('id', $assigned);
        } else {
            $query->whereRaw('1 = 0');
        }

        return response()->json($query->get());
    }

    public function monitoring()
    {
        return response()->json(SuccessOrders::
        where('user_id', Auth::user()->id)
            ->whereDate('created_at', now())
            ->with(['product', 'client', 'client.city', 'client.area'])
            ->get());
    }

    /**
     * Driver app — every client of the organization that has a GPS location,
     * for the "all clients on the map" screen. location is stored as "lat,lng".
     */
    public function clients_map()
    {
        $orgId = auth()->user()->organization_id;

        $clients = Client::where('organization_id', $orgId)
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->where('location', '!=', '0')
            ->get(['id', 'fullname', 'phone', 'location', 'balance', 'container']);

        $data = $clients->map(function ($c) {
            $parts = explode(',', $c->location);
            if (count($parts) < 2) {
                return null;
            }

            $lat = trim($parts[0]);
            $lng = trim($parts[1]);

            if (!is_numeric($lat) || !is_numeric($lng)) {
                return null;
            }

            return [
                'id' => $c->id,
                'fullname' => $c->fullname,
                'phone' => $c->phone,
                'lat' => (float) $lat,
                'lng' => (float) $lng,
                'balance' => $c->balance,
                'container' => $c->container,
            ];
        })->filter()->values();

        return response()->json($data);
    }

    public function areas_filter(Request $request)
    {
        $str = implode(',', $request->areas);

        $areas = auth()->user();
        $areas->areas = $str;
        $areas->save();

        return response()->json(['message' => 'success']);
    }

    public function muborak_refresh()
    {
        $areas = Area::where('city_id', 58)->get();

        foreach ($areas as $area) {
            $newArea = new Area();
            $newArea->organization_id = 17;
            $newArea->city_id = 99;
            $newArea->name = $area->name;
            $newArea->save();

            $clients = Client::where('area_id', $area->id)->get();

            foreach ($clients as $item) {
                $newClient = new Client();
                $newClient->organization_id = 17;
                $newClient->user_id = 56;
                $newClient->city_id = 99;
                $newClient->area_id = $newArea->id;
                $newClient->fullname = $item->fullname;
                $newClient->street = $item->street;
                $newClient->home_number = $item->home_number;
                $newClient->entrance = $item->entrance;
                $newClient->floor = $item->floor;
                $newClient->apartment_number = $item->apartment_number;
                $newClient->address = $item->address;
                $newClient->location = $item->location;
                $newClient->login = '17' . $item->login;
                $newClient->password = '17' . $item->password;
                $newClient->balance = $item->balance;
                $newClient->container = $item->container;
                $newClient->bonus = $item->bonus;
                $newClient->phone = $item->phone;
                $newClient->phone2 = $item->phone2;
                $newClient->activated_at = $item->activated_at;
                $newClient->save();
            }
        }
    }
}
