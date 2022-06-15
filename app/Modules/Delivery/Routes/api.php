<?php

use App\Modules\Delivery\Http\Controllers\DeliveryApiController;
use App\Modules\Delivery\Http\Controllers\TransportCompanyApiController;
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

Route::middleware('auth:api')->get('/delivery', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'delivery'], function () {
    Route::get('/fast', [DeliveryApiController::class, 'fast']);
    Route::get('/slow', [DeliveryApiController::class, 'slow']);
});

Route::group(['prefix' => 'transport-company'], function () {
    Route::group(['prefix' => 'calculation'], function () {
        Route::get('/fast-delivery', [TransportCompanyApiController::class, 'calculationFastDelivery']);
        Route::get('/slow-delivery', [TransportCompanyApiController::class, 'calculationSlowDelivery']);
    });
});
