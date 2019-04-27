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

// Route::middleware('auth:api')->group( 
Route::group(['middleware' => ['auth:api']], 
    function () { 
        Route::post('/logout', 'AuthController@logout');
        Route::post('/submitArt', 'ArtController@store');
        Route::put('/updateArt', 'ArtController@update');
        Route::delete('/deleteArt', 'ArtController@delete');
        Route::post('/like', 'ArtController@like');
    }
);

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::get('/users', 'UserController@index');
Route::get('/Art', 'ArtController@index');
Route::get('/show/{id}', 'ArtController@show');
Route::get('/recentArt', 'ArtController@recentArt');
