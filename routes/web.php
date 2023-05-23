<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('Delivery', function () {
    return view ('bizpartner/bizpartner_template');

});


//get data fron controller
Route::get('bizpartner/getDataById/{bp_id}','Bizpartner\DeliveryController@getBpById');
Route::get('bizpartner/getBpData','Bizpartner\DeliveryController@getBpData');
Route::post('bizpartner/create_data','Bizpartner\DeliveryController@createBP');
Route::post('bizpartner/update_data','Bizpartner\DeliveryController@updateBP');
Route::post('bizpartner/removeDataById','Bizpartner\DeliveryController@removeBpById');

