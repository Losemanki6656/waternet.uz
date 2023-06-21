<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);


Route::get('/setting1', [App\Http\Controllers\SettingController::class, 'setting1'])->name('setting1');
Route::get('/setting2', [App\Http\Controllers\SettingController::class, 'setting2'])->name('setting2');
Route::get('/setting3', [App\Http\Controllers\SettingController::class, 'setting3'])->name('setting3');
Route::get('/setting4', [App\Http\Controllers\SettingController::class, 'setting4'])->name('setting4');


Route::get('/search/areas', [App\Http\Controllers\HomeController::class, 'search_areas'])->name('search_areas');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/privace', [App\Http\Controllers\TrafficController::class, 'politica'])->name('politica');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user_update');
    Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('user_destroy');
    Route::post('/users/create', [App\Http\Controllers\UserController::class, 'store'])->name('user_create');

    Route::get('/statistics', [App\Http\Controllers\HomeController::class, 'statistics'])->name('statistics');

    Route::get('/admin/refresh', [App\Http\Controllers\HomeController::class, 'muborak_refresh'])->name('muborak_refresh');

    Route::post('/administration/active-traffics', [App\Http\Controllers\HomeController::class, 'active_traffics'])->name('active_traffics');

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users_create');

    Route::get('/clients', [App\Http\Controllers\HomeController::class, 'clients'])->name('clients');
    Route::get('/export_clients', [App\Http\Controllers\HomeController::class, 'export_clients'])->name('ClientsExportToExcel');
    Route::get('/status-client/{id}', [App\Http\Controllers\HomeController::class, 'status_client'])->name('status_client');


    Route::post('/client-edit/{id}', [App\Http\Controllers\HomeController::class, 'client_edit'])->name('client_edit');
    Route::post('/client-delete', [App\Http\Controllers\HomeController::class, 'delete_client'])->name('delete_client');

    Route::post('/zakaz', [App\Http\Controllers\HomeController::class, 'zakaz'])->name('zakaz');
    Route::get('/add-client', [App\Http\Controllers\HomeController::class, 'add_client_page'])->name('add_client_page');
    Route::post('/add-client-success', [App\Http\Controllers\HomeController::class, 'add_client'])->name('add_client');

    Route::post('/add-region', [App\Http\Controllers\HomeController::class, 'add_region'])->name('add_region');

    Route::get('/orders', [App\Http\Controllers\HomeController::class, 'orders'])->name('orders');

    Route::get('/products', [App\Http\Controllers\HomeController::class, 'products'])->name('products');
    Route::post('/add-product', [App\Http\Controllers\HomeController::class, 'add_product'])->name('add_product');

    Route::get('/workers', [App\Http\Controllers\HomeController::class, 'workers'])->name('workers');

    Route::get('/sities', [App\Http\Controllers\HomeController::class, 'sities'])->name('sities');
    Route::post('/add-sity', [App\Http\Controllers\HomeController::class, 'add_city'])->name('add_city');


    Route::get('/results', [App\Http\Controllers\HomeController::class, 'results'])->name('results');

    Route::get('/results-export', [App\Http\Controllers\HomeController::class, 'export_results'])->name('export_results');

    Route::post('/add-order/{id}', [App\Http\Controllers\HomeController::class, 'add_order'])->name('add_order');
    Route::post('/add-order-check', [App\Http\Controllers\HomeController::class, 'add_order_check'])->name('add_order_check');

    Route::post('/delete-Order', [App\Http\Controllers\HomeController::class, 'delete_Order'])->name('delete_Order');
    Route::post('/success-order/{id}', [App\Http\Controllers\HomeController::class, 'success_order'])->name('success_order');


    Route::get('/location', [App\Http\Controllers\HomeController::class, 'location'])->name('location');
    Route::get('/location/{id}', [App\Http\Controllers\HomeController::class, 'location_id'])->name('location_id');
    Route::get('/view-location/{id}', [App\Http\Controllers\ClientController::class, 'view_location'])->name('view_location');


    Route::post('/client-price/{id}', [App\Http\Controllers\ClientController::class, 'client_price'])->name('client_price');
    Route::post('/client-container/{id}', [App\Http\Controllers\ClientController::class, 'client_container'])->name('client_container');

    Route::post('/client-price-edit/{id}', [App\Http\Controllers\ClientController::class, 'client_price_edit'])->name('client_price_edit');
    Route::get('/client-price-delete/{id}', [App\Http\Controllers\ClientController::class, 'client_price_delete'])->name('client_price_delete');
    Route::post('/client-container-edit/{id}', [App\Http\Controllers\ClientController::class, 'client_container_edit'])->name('client_container_edit');
    Route::get('/client-container-delete/{id}', [App\Http\Controllers\ClientController::class, 'client_container_delete'])->name('client_container_delete');


    Route::post('/edit-product/{id}', [App\Http\Controllers\ClientController::class, 'edit_product'])->name('edit_product');
    Route::post('/delete-product', [App\Http\Controllers\ClientController::class, 'delete_product'])->name('delete_product');

    Route::get('/succ-ord-view/{id}', [App\Http\Controllers\ClientController::class, 'success_order_view'])->name('success_order_view');

    Route::get('/regions/regions', [App\Http\Controllers\HomeController::class, 'regions'])->name('regions');
    Route::get('/regions/cities', [App\Http\Controllers\HomeController::class, 'cities'])->name('cities');
    Route::post('/regions/edit-region/{id}', [App\Http\Controllers\HomeController::class, 'edit_region'])->name('edit_region');
    Route::post('/regions/delete-region', [App\Http\Controllers\HomeController::class, 'delete_region'])->name('delete_region');
    Route::post('/regions/edit-city/{id}', [App\Http\Controllers\HomeController::class, 'edit_city'])->name('edit_city');
    Route::post('/regions/delete-city', [App\Http\Controllers\HomeController::class, 'delete_city'])->name('delete_city');

    Route::get('/soldproducts/{id}', [App\Http\Controllers\HomeController::class, 'soldproducts'])->name('soldproducts');
    Route::get('/take-client-container/{id}', [App\Http\Controllers\HomeController::class, 'take_client_container'])->name('take_client_container');

    Route::get('/warehouse', [App\Http\Controllers\ClientController::class, 'entry_container'])->name('entry_container');
    Route::get('/warehouse/take-products', [App\Http\Controllers\ClientController::class, 'take_products'])->name('take_products');
    Route::get('/warehouse/entry-products', [App\Http\Controllers\ClientController::class, 'entry_products'])->name('entry_products');
    Route::get('/warehouse/entry-container', [App\Http\Controllers\ClientController::class, 'entry_container'])->name('entry_container');
    Route::get('/warehouse/take-container', [App\Http\Controllers\ClientController::class, 'take_container'])->name('take_container');


    Route::post('/warehouse/edit-entry-container/{id}', [App\Http\Controllers\ClientController::class, 'edit_entry_container'])->name('edit_entry_container');
    Route::post('/warehouse/delete-entry-container', [App\Http\Controllers\ClientController::class, 'delete_entry_container'])->name('delete_entry_container');
    Route::post('/warehouse/take-edit-container/{id}', [App\Http\Controllers\ClientController::class, 'take_edit_container'])->name('take_edit_container');
    Route::post('/warehouse/take-delete-container', [App\Http\Controllers\ClientController::class, 'take_delete_container'])->name('take_delete_container');
    Route::post('/warehouse/edit-entry-product/{id}', [App\Http\Controllers\ClientController::class, 'edit_entry_product'])->name('edit_entry_product');
    Route::post('/warehouse/delete-entry-product', [App\Http\Controllers\ClientController::class, 'delete_entry_product'])->name('delete_entry_product');
    Route::post('/warehouse/take-edit-product/{id}', [App\Http\Controllers\ClientController::class, 'take_edit_product'])->name('take_edit_product');
    Route::post('/warehouse/take-delete-product', [App\Http\Controllers\ClientController::class, 'take_delete_product'])->name('take_delete_product');


    Route::post('/warehouse/take-succ-products', [App\Http\Controllers\ClientController::class, 'add_take_product'])->name('add_take_product');
    Route::post('/warehouse/entry-succ-products', [App\Http\Controllers\ClientController::class, 'add_entry_product'])->name('add_entry_product');
    Route::post('/warehouse/entry-succ-container', [App\Http\Controllers\ClientController::class, 'add_entry_container'])->name('add_entry_container');
    Route::post('/warehouse/take-succ-container', [App\Http\Controllers\ClientController::class, 'take_entry_container'])->name('take_entry_container');

    Route::get('/smsmanager/send-message', [App\Http\Controllers\ClientController::class, 'send_message'])->name('send_message');
    Route::get('/smsmanager/send-message-tg', [App\Http\Controllers\ClientController::class, 'send_message_tg'])->name('send_message_tg');
    Route::get('/smsmanager/success-message', [App\Http\Controllers\ClientController::class, 'success_message'])->name('success_message');
    Route::get('/smsmanager/sms-text', [App\Http\Controllers\ClientController::class, 'sms_text'])->name('sms_text');

    Route::post('/smsmanager/sms-text-new', [App\Http\Controllers\ClientController::class, 'sms_text_new'])->name('sms_text_new');

    Route::get('/traffics-merchant', [App\Http\Controllers\ClientController::class, 'traffic_merchant'])->name('traffic_merchant');
    Route::get('/user-info', [App\Http\Controllers\HomeController::class, 'user_info'])->name('user_info');

    Route::post('/smsmanager/send-client-message/{id}', [App\Http\Controllers\ClientController::class, 'send_client_message'])->name('send_client_message');


    Route::get('/administration/organization/organizations', [App\Http\Controllers\TrafficController::class, 'organizations'])->name('organizations');
    Route::get('/administration/traffics', [App\Http\Controllers\TrafficController::class, 'traffics'])->name('traffics');
    Route::get('/administration/user_organizations', [App\Http\Controllers\TrafficController::class, 'user_organizations'])->name('user_organizations');
    Route::get('/administration/users-admin', [App\Http\Controllers\UserController::class, 'users_admin'])->name('users_admin');


    Route::post('/administration/add-traffic', [App\Http\Controllers\TrafficController::class, 'add_traffic'])->name('add_traffic');
    Route::post('/administration/add-organization', [App\Http\Controllers\TrafficController::class, 'add_organization'])->name('add_organization');
    Route::post('/administration/edit-organization/{id}', [App\Http\Controllers\TrafficController::class, 'edit_organization'])->name('edit_organization');
    Route::post('/administration/delete-organization/{id}', [App\Http\Controllers\TrafficController::class, 'delete_organization'])->name('delete_organization');
    Route::post('/administration/edit-traffic/{id}', [App\Http\Controllers\TrafficController::class, 'edit_traffic'])->name('edit_traffic');
    Route::post('/administration/delete-traffic/{id}', [App\Http\Controllers\TrafficController::class, 'delete_traffic'])->name('delete_traffic');

    Route::post('/order-edit/{id}', [App\Http\Controllers\HomeController::class, 'order_edit'])->name('order_edit');
    Route::get('/client-order-edit/{id}', [App\Http\Controllers\HomeController::class, 'client_order_edit'])->name('client_order_edit');

    Route::get('/admin-traffics', [App\Http\Controllers\ClientController::class, 'admin_traffics'])->name('admin_traffics');

    Route::get('/results/orders', [App\Http\Controllers\ClientController::class, 'resultorders'])->name('result_orders');
    Route::get('/results/resulttakeproducts', [App\Http\Controllers\ClientController::class, 'resulttakeproducts'])->name('result_take');
    Route::get('/results/resultsold', [App\Http\Controllers\ClientController::class, 'resultsold'])->name('resultsold');
    Route::get('/results/summresult', [App\Http\Controllers\ClientController::class, 'summresult'])->name('summresult');
    Route::get('/results/resultentrycontainer', [App\Http\Controllers\ClientController::class, 'resultentrycontainer'])->name('resultentrycontainer');

    Route::get('/results/payment1', [App\Http\Controllers\ClientController::class, 'payment1'])->name('payment1');
    Route::get('/results/payment2', [App\Http\Controllers\ClientController::class, 'payment2'])->name('payment2');
    Route::get('/results/payment3', [App\Http\Controllers\ClientController::class, 'payment3'])->name('payment3');
    Route::get('/results/resultlos', [App\Http\Controllers\ClientController::class, 'dolgresult'])->name('dolgresult');
    Route::get('/results/qarzdorlar', [App\Http\Controllers\ClientController::class, 'dolgs'])->name('dolgs');

    Route::post('/send-sms', [App\Http\Controllers\ClientController::class, 'send_sms'])->name('send_sms');
    Route::get('/reklama', [App\Http\Controllers\TrafficController::class, 'reklama'])->name('reklama');
    Route::get('/organization/trafficorgan/{id}', [App\Http\Controllers\TrafficController::class, 'trafficorgan'])->name('trafficorgan');
    Route::get('/organization/addpriceorgan/{id}', [App\Http\Controllers\TrafficController::class, 'indexpriceorgan'])->name('addpriceorgan');
    Route::post('/organization/add-success-price-org/{id}', [App\Http\Controllers\TrafficController::class, 'add_price_organization'])->name('add_price_organization');
    Route::post('/organization/add-success-traffic-org/{id}', [App\Http\Controllers\TrafficController::class, 'add_traffic_organization'])->name('add_traffic_organization');
    Route::post('/organization/edit-success-price-org/{id}', [App\Http\Controllers\TrafficController::class, 'edit_price_organization'])->name('edit_price_organization');
    Route::post('/organization/delete-success-price-org/{id}', [App\Http\Controllers\TrafficController::class, 'delete_price_organization'])->name('delete_price_organization');
    Route::post('/organization/edit-success-traffic-org/{id}', [App\Http\Controllers\TrafficController::class, 'edit_traffic_organization'])->name('edit_traffic_organization');
    Route::get('/organization/delete-traffic-org/{id}', [App\Http\Controllers\TrafficController::class, 'delete_traffic_organ'])->name('delete_traffic_organ');


    Route::get('/organization/client-app', [App\Http\Controllers\TrafficController::class, 'client_app'])->name('client_app');
    Route::post('/organization/client-app-carts', [App\Http\Controllers\TrafficController::class, 'client_app_carts_add'])->name('client_app_carts_add');
    Route::post('/organization/client-app-carts/{id}', [App\Http\Controllers\TrafficController::class, 'client_app_carts_edit'])->name('client_app_carts_edit');
    Route::post('/organization/client-app-cart-delete/{id}', [App\Http\Controllers\TrafficController::class, 'client_app_carts_delete'])->name('client_app_carts_delete');

    Route::post('/organization/client-app-swiper', [App\Http\Controllers\TrafficController::class, 'client_app_swiper_add'])->name('client_app_swiper_add');
    Route::post('/organization/client-app-swiper/{id}', [App\Http\Controllers\TrafficController::class, 'client_app_swiper_edit'])->name('client_app_swiper_edit');
    Route::post('/organization/client-app-swiper-delete/{id}', [App\Http\Controllers\TrafficController::class, 'client_app_swiper_delete'])->name('client_app_swiper_delete');



    Route::get('/organization/organization-app', [App\Http\Controllers\TrafficController::class, 'organization_app'])->name('organization_app');
    Route::post('/organization/organization-app-swiper', [App\Http\Controllers\TrafficController::class, 'organization_app_swiper_add'])->name('organization_app_swiper_add');
    Route::post('/organization/organization-app-swiper/{id}', [App\Http\Controllers\TrafficController::class, 'organization_app_swiper_edit'])->name('organization_app_swiper_edit');
    Route::post('/organization/organization-app-swiper-delete/{id}', [App\Http\Controllers\TrafficController::class, 'organization_app_swiper_delete'])->name('organization_app_swiper_delete');


    Route::get('/organization/admin-app-cart', [App\Http\Controllers\TrafficController::class, 'organization_app_cart'])->name('organization_app_cart');
    Route::post('/organization/admin-app-cart', [App\Http\Controllers\TrafficController::class, 'admin_app_cart_add'])->name('admin_app_cart_add');
    Route::post('/organization/admin-app-cart/{id}', [App\Http\Controllers\TrafficController::class, 'admin_app_cart_edit'])->name('admin_app_cart_edit');
    Route::post('/organization/admin-app-cart-delete/{id}', [App\Http\Controllers\TrafficController::class, 'admin_app_cart_delete'])->name('admin_app_cart_delete');
});