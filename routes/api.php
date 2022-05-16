<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;

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

Route::get('/client/products', [ClientController::class, 'client_products']);
Route::get('/client/add-order', [ClientController::class, 'client_add_order']);
Route::get('/client/orders', [ClientController::class, 'client_order']);
Route::get('/client/edit-order', [ClientController::class, 'client_order_edit']);

Route::get('/client-profile', [ClientController::class, 'client_profile']);
