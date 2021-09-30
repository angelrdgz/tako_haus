<?php

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

Route::get('/', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@loginPost');

Route::post('logout', 'AuthController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', 'DashboardController');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('cuentas', 'AccountController');
    Route::resource('ordenes', 'OrderController');
    Route::resource('compras', 'PurchaseController');
    Route::resource('productos', 'ProductController');
    Route::get('tipos/{sizeId}', 'ProductTypeController@index');
    Route::resource('tamanos/{productId}', 'ProductSizeController');    
    Route::resource('usuarios', 'UserController');
    
    
});
