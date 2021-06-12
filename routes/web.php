<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin/login', function () {
    return view('auth.login');
});


Route::group( [ 'namespace' => 'admin'], function()
{
    Route::get('home', 'HomeController@home')->name('home');
    Route::get('charts', 'HomeController@chart')->name('chart');
});

Route::group( [ 'prefix' => 'admin' , 'as' => 'admin.', 'namespace' => 'admin', 'middleware' => 'auth'], function()
{
    Route::resource('/restaurants', 'RestaurantController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/extra-categories', 'ExtraCategoryController');
    Route::resource('/delivery-addresses', 'DeliveryAddressController');
    Route::resource('/discounts', 'DiscountController');
    Route::resource('/extras', 'ExtraController');
    Route::resource('/foods', 'FoodController');
    Route::get('food/{id}/options','FoodController@getOptions')->name('foods.options');
    Route::resource('/options', 'OptionController');
    Route::post('food/{id}/options','OptionController@storeByFoodId')->name('foods.options');
    Route::get('food/{food_id}/option/{id}/update','OptionController@editByFoodId')->name('foods.options.edit');
    Route::put('food/{food_id}/option/{id}/update','OptionController@updateByFoodId')->name('foods.options.update');

    Route::resource('/orders', 'OrderController');
    Route::get('order/{id}/details','OrderController@getDetails')->name('order.details');
    Route::get('detail/{id}/extras','OrderDetailController@getExtras')->name('detail.extras');

    Route::resource('/blogs', 'BlogController');
    Route::resource('/footers', 'FooterController');
    Route::resource('/users', 'UserController');

    Route::post('category/{id}/extras','CategoryController@addExtra')->name('categories.extra');
    Route::get('category/{id}/foods','CategoryController@getFoods')->name('category.foods');
    Route::get('category/{id}/extras','ExtraCategoryController@getExtras')->name('category.get.extras');
    Route::post('option/{id}/extra','OptionController@addExtra')->name('option.extra');

    Route::resource('/feedbacks', 'FeedbackController');
    Route::resource('/policies', 'PolicyController');

    Route::post('category/{id}/foods','FoodController@storeByCategoryId')->name('category.foods');
    Route::post('category/{id}/extra','ExtraController@storeByCategoryId')->name('category.extras');

});

Route::prefix('admin')->group(function(){
    Auth::routes();
});

Route::get('/admin/home', 'HomeController@index')->name('home');
