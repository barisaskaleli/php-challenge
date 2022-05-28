<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::post('register', [ApiController::class, 'register']);

Route::fallback(function () {
    return response()->json(['message' => 'Page not found.'], 404);
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/purchase', [ApiController::class, 'purchase']);
    Route::post('/check-subscriptions', [ApiController::class, 'checkSubscriptions']);

});
