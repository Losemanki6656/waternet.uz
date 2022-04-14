<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserOrganization;
use App\Models\Order;
use App\Models\Area;
use App\Models\RegionUser;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 422);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth('api')->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth('api')->user());
    }

    public function orders(Request $request) {

        if(RegionUser::where('user_id',Auth::user()->id)->get()->count() == 0)
            return response()->json(
            Order::query()
            ->where('status',0)
            ->where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
            ->with(['product' , 'client','client.city', 'client.area'])
            ->has('client')
            ->when(request('area_id'), function ($query, $area_id) {
                return $query->where('area_id', $area_id);
             })
            ->get());
        else
        {
            $str = explode(',',RegionUser::where('user_id',Auth::user()->id)->value('areas'));
            $intareas = array_map('intval', $str);
            return response()->json(
            Order::query()
            ->where('status',0)
            ->whereIn('area_id',$intareas)
            ->where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
            ->with(['product' , 'client','client.city', 'client.area'])
            ->has('client')
            ->when(request('area_id'), function ($query, $area_id) {
                return $query->where('area_id', $area_id);
             })
            ->get());
        }
           
    }

    public function order_filter(Request $request) {
            return response()->json(Order::query()
            ->where('status',0)
            ->where('area_id', $request->area_id)
            ->where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
            ->with(['product' , 'client','client.city', 'client.area'])->get());
    }

    public function order_status() {

        $payments = array(
            "1" => "Yetqazildi",
            "3" => "Bekor qilindi",
            "4" => "Manzil topilmadi",
            "5" => "Manzilda xech kim yoq"
        );
        
        return response()->json($payments);
    }

    public function payments() {

        $payments = array(
            "1" => "Naqd",
            "2" => "Plastik",
            "3" => "Pul ko'chirish"
        );
        
        return response()->json($payments);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600,
            'user' => auth('api')->user()
        ]);
    }
}