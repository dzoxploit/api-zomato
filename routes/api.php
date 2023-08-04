<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'api.version'], function () {
    Route::group(['prefix' => 'v1'], function () {
        // Restaurant related routes
        Route::get('restaurants', 'RestaurantController@searchRestaurants');
        
        // User authentication routes
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::middleware('auth:api')->post('logout', 'AuthController@logout');

        // Other routes for v1 API
    });
});


Route::group(['middleware' => 'api.version:v2'], function () {
    // API routes for version 2
    // ...
});