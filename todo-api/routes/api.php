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


Route::group([

    'middleware' => ['api'],

], function ($router) {
   
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    
    Route::group([

        'middleware' => ['auth'],
        
    ], function ($router) {

        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

        Route::group([
            
            'prefix' => 'todos'
        
        ], function($router) {

            Route::get('', 'TodoController@index');
            Route::get('{todo}', 'TodoController@show')
                ->middleware('can:show,todo');
            Route::post('', 'TodoController@store');
            Route::put('{todo}', 'TodoController@update')
                ->middleware('can:update,todo');
            Route::delete('{todo}', 'TodoController@destroy')
                ->middleware('can:delete,todo');
            
        });
    });
  

});


