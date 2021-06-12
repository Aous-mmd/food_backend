<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'categories'
],function($router){
    Route::get('/get/',[\App\Http\Controllers\Api\CategoryController::class,'show']);
    Route::get('/',[\App\Http\Controllers\Api\CategoryController::class,'get']);
    Route::get('/all',[\App\Http\Controllers\Api\CategoryController::class,'all']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'food'
],function($router){
    Route::get('/get/{id}',[\App\Http\Controllers\Api\FoodController::class,'show']);

});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'options'
],function($router){
    Route::get('/get/{id}',[\App\Http\Controllers\Api\OptionController::class,'show']);
    Route::get('/extras/{id}',[\App\Http\Controllers\Api\OptionController::class,'getExtras']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
            'prefix'=>'restaurant'
],function($router){
    Route::get('/get/',[\App\Http\Controllers\Api\RestaurantController::class,'show']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'address'
],function($router){
    Route::get('/get/',[\App\Http\Controllers\Api\AddressController::class,'show']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'user'
],function($router){
    Route::post('/create/',[\App\Http\Controllers\Api\UserController::class,'store']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'/home'
],function($router){
    Route::get('/footer',[\App\Http\Controllers\Api\HomeController::class,'footer']);
    Route::get('/blogs',[\App\Http\Controllers\Api\HomeController::class,'blogs']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'/order'
],function($router){
    Route::get('/',[\App\Http\Controllers\Api\OrderController::class,'index']);
    Route::post('/change',[\App\Http\Controllers\Api\OrderController::class,'change']);
    Route::post('/store',[\App\Http\Controllers\Api\OrderController::class,'store']);
    Route::post('/check',[\App\Http\Controllers\Api\OrderController::class,'check']);
    Route::post('/delete',[\App\Http\Controllers\Api\OrderController::class,'delete']);
    Route::post('/clear',[\App\Http\Controllers\Api\OrderController::class,'clear']);
    Route::get('/get/{id}',[\App\Http\Controllers\Api\OrderController::class,'get']);
    Route::get('/status/{id}',[\App\Http\Controllers\Api\OrderController::class,'status']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'search'
],function($router){
    Route::get('/{type}',[\App\Http\Controllers\Api\FoodController::class,'search']);
});
Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Controllers',
    'prefix'=>'auth'
],function($router){
    Route::post('login',[\App\Http\Controllers\Api\AuthController::class,'login'])->name('login');
    Route::get('check_validity',[\App\Http\Controllers\Api\AuthController::class,'isValidToken'])->name('check_validity');
    Route::get('check_connection',[\App\Http\Controllers\Api\AuthController::class,'check']);

});
Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'feedback'
],function($router){
    Route::post('/',[\App\Http\Controllers\Api\FeedbackController::class,'store']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'policy'
],function($router){
    Route::get('/',[\App\Http\Controllers\Api\PolicyController::class,'show']);
});

Route::group([
    'middleware'=>'api',
    'namespace'=>'App\Http\Api\Controllers',
    'prefix'=>'slider'
],function($router){
    Route::get('/',[\App\Http\Controllers\Api\SliderController::class,'index']);
});


Route::group( [ 'prefix' => 'admin' , 'as' => 'admin.', 'namespace' => 'dashboard', 'middleware' => 'auth:api'], function()
{
    Route::get('categories', 'CategoryController@index');
    Route::post('categories', 'CategoryController@store');
    Route::post('categories/{id}', 'CategoryController@update');
    Route::delete('categories/{id}', 'CategoryController@destroy');

    Route::get('category/{id}/foods','FoodController@getFoodsByCategory');

    Route::get('foods', 'FoodController@index');
    Route::post('foods', 'FoodController@store');
    Route::post('foods/{id}', 'FoodController@update');
    Route::delete('foods/{id}', 'FoodController@destroy');

    Route::get('food/{id}/options','FoodOptionController@getOptionsByFoodId');
    Route::post('options', 'FoodOptionController@store');
    Route::post('options/{id}', 'FoodOptionController@update');
    Route::delete('options/{id}', 'FoodOptionController@destroy');

    Route::get('delivery-addresses', 'DeliveryAddressController@index');
    Route::post('delivery-addresses', 'DeliveryAddressController@store');
    Route::post('delivery-addresses/{id}', 'DeliveryAddressController@update');
    Route::delete('delivery-addresses/{id}', 'DeliveryAddressController@destroy');

    Route::get('restaurants', 'RestaurantController@index');
    Route::post('restaurants/{id}', 'RestaurantController@update');
    Route::delete('restaurants/{id}', 'RestaurantController@destroy');

    Route::get('users', 'UserController@index');
    Route::post('users', 'UserController@store');
    Route::post('users/{id}', 'UserController@update');
    Route::delete('users/{id}', 'UserController@destroy');

    Route::get('discounts', 'DiscountController@index');
    Route::post('discounts', 'DiscountController@store');
    Route::post('discounts/{id}', 'DiscountController@update');
    Route::delete('discounts/{id}', 'DiscountController@destroy');

    Route::get('feedback', 'FeedBackController@index');
    Route::delete('feedback/{id}', 'FeedBackController@destroy');

    Route::get('policies', 'PrivacyPolicyController@index');
    Route::post('policies', 'PrivacyPolicyController@store');
    Route::post('policies/{id}', 'PrivacyPolicyController@update');
    Route::delete('policies/{id}', 'PrivacyPolicyController@destroy');

    Route::get('orders', 'OrderController@index');
    Route::post('orders/{id}', 'OrderController@update');
    Route::delete('orders/{id}', 'OrderController@destroy');

    Route::get('sliders', 'SliderController@index');
    Route::post('sliders', 'SliderController@store');
    Route::post('sliders/{id}', 'SliderController@update');
    Route::delete('sliders/{id}', 'SliderController@destroy');

    Route::get('extra-categories', 'ExtraCategoryController@index');
    Route::post('extra-categories', 'ExtraCategoryController@store');
    Route::post('extra-categories/{id}', 'ExtraCategoryController@update');
    Route::delete('extra-categories/{id}', 'ExtraCategoryController@destroy');

    Route::get('extras', 'ExtraController@index');
    Route::post('extras', 'ExtraController@store');
    Route::post('extras/{id}', 'ExtraController@update');
    Route::delete('extras/{id}', 'ExtraController@destroy');


});

