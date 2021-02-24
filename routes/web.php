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


Auth::routes();

Route::group(['middleware' => ['auth']] , function(){

    Route::get('/', 'FrontEndController@index')->name('main');
    Route::get('/home', 'FrontEndController@index')->name('home');
    Route::get('/detail/{id}','FrontEndController@show')->name('product.detail');
    Route::post('/cart/add/{id}','ShoppingController@Add_To_Cart')->name('cart.add');
    Route::get('/cart','ShoppingController@display')->name('cart');
    Route::get('/cart/remove/{id}','ShoppingController@Remove_Cart')->name('cart.delete');
    Route::resource('products','ProductController');
});
