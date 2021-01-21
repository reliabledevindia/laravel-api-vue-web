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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', 'Api\AuthController@login');
    Route::get('refresh', 'Api\AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'Api\AuthController@user');
        Route::post('logout', 'Api\AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('get-polls','Api\MyPollsController@getPolls')->middleware('isAuthUser');
    Route::post('update-user-polls-vote','Api\MyPollsController@updateUserVote')->middleware('isAuthUser');
});

