<?php

use App\Http\Controllers\RateUserController;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TrafficController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/client/login', [AuthController::class, 'clientlogin']);
});

Route::group([
    'middleware' => 'auth:api'
], function ($router) {
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/orders', [AuthController::class, 'orders']);
    Route::get('/order/status', [AuthController::class, 'order_status']);
    Route::get('/payment/types', [AuthController::class, 'payments']);
    Route::post('/success-order', [HomeController::class, 'success_order_api']);
    Route::post('/client/add-location', [HomeController::class, 'add_location']);

    Route::get('/driver/regions', [HomeController::class, 'driver_regions']);
    Route::post('/driver/areas', [HomeController::class, 'areas']);
    Route::post('/driver/areas/filter', [HomeController::class, 'areas_filter']);
    Route::get('/driver/monitoring', [HomeController::class, 'monitoring']);


});


Route::post('/client/bot_token', [ClientController::class, 'bot_token']);
Route::get('/client/logout/{client_id}', [ClientController::class, 'logout_client']);

Route::post('/client/registration/{client_id}', [ClientController::class, 'registration']);

Route::get('/client/client-info', [ClientController::class, 'client_info']);
Route::get('/client/products', [ClientController::class, 'client_products']);

//Route::get('/client/add-order', [ClientController::class, 'client_add_order']);
Route::post('/client/create/order', [ClientController::class, 'client_add_order']);
Route::put('/client/order/update', [ClientController::class, 'client_order_edit']);
Route::delete('/client/order/delete', [ClientController::class, 'client_order_delete']);

Route::get('/client/orders', [ClientController::class, 'client_order']);

Route::get('/client/edit-order', [ClientController::class, 'client_order_edit']);

Route::get('/client/delete-order', [ClientController::class, 'client_order_delete']);

Route::get('/client/success/orders', [ClientController::class, 'cl_succ_orders']);
Route::get('/client/admin/carts', [TrafficController::class, 'admin_carts_api']);

Route::get('/client/admin/swipers', [TrafficController::class, 'admin_swipers_api']);
Route::get('/client/admin/orgswipers', [TrafficController::class, 'admin_orgswipers_api']);
Route::get('/client/carts/cart', [TrafficController::class, 'cart_photo']);

Route::get('/client-profile', [TrafficController::class, 'client_profile']);

Route::get('/client/order-rates', [RateUserController::class, 'index']);

Route::delete('/client/telegram/delete/{chat_id}', [RateUserController::class, 'delete_client']);

Route::put('/client/order-rates/{client_id}/update', [RateUserController::class, 'update']);

Route::post('/6379098700:AAGxRC5F6EwLE9hE4XcsZJzfzS_lNspGVZY', [TelegramController::class, 'index'])->name('webhook');
