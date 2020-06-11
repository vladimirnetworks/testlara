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


Auth::routes(['verify' => true]);

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



Route::get('gooz', 'API\listcontroller@list1')->name('gaz');
Route::get('gooz2', 'API\listcontroller@list2');


Route::group(['middleware' => 'auth:api'], function(){

    Route::get('mylist', 'API\listcontroller@list1')->middleware('verified');
    
});


//oute::get('mylist', 'API\listcontroller@list1')->middleware('verified');

Route::group([ 'prefix' => 'auth' ], function () {

    Route::post('login', 'API\UserController@login');
    Route::post('register', 'API\UserController@register');

    Route::post('fakelogin', 'API\UserController@fakelogin');

       Route::group([ 'middleware' => 'auth:api' ], function() {
           Route::get('logout', 'API\UserController@logout');
           Route::get('user', 'API\UserController@user');
       });
    });