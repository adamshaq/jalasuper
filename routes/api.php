<?php

use Illuminate\Http\Request;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('signin', 'API\Auth\SignInController@index');
Route::post('signup', 'API\Auth\SignUpController@index');
Route::post('all-user', 'API\Auth\UserController@allUser');
Route::post('delete-user', 'API\Auth\UserController@destroy');

Route::get('check-user/{id?}','API\Auth\UserController@show')->middleware('jwt.verify');

// Route::group(['prefix'=> 'check-register'], function(){
//     Route::post('/','API\CheckRegisterController@index');
//     Route::post('/update','API\CheckRegisterController@update');
// });

Route::group(['middleware' => 'jwt.verify'], function(){
    
    Route::group(['prefix'=> 'check-register'], function(){
        Route::post('/','API\CheckRegisterController@index');
        Route::post('/update','API\CheckRegisterController@update');
    });
});
