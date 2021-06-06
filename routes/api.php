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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('games', App\Http\Controllers\API\GameAPIController::class);

Route::resource('game-properties', App\Http\Controllers\API\GamePropertyAPIController::class);


Route::resource('promo-tools', App\Http\Controllers\API\PromoToolAPIController::class);


Route::resource('engaging-social', App\Http\Controllers\API\EngagingSocialToolAPIController::class);
