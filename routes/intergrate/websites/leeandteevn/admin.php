<?php

use Illuminate\Support\Facades\Route;

if (!defined('API_ROUTE')) {
    define('API_ROUTE', 'api');
}

if (!defined('INTERGRATE_ROUTE')) {
    define('INTERGRATE_ROUTE', 'self');
}

if (!defined('W000_ROUTE')) {
    define('W000_ROUTE', 'leeandteevn');
}

Route::group(['prefix' => API_ROUTE.'/'.INTERGRATE_ROUTE.'/'.W000_ROUTE], function () {

    /*
    |-------------------------------------------------------
    | TOKEN
    |-------------------------------------------------------
    */
    Route::get('/get-token', [\App\Http\Controllers\Api\Self\AccesstokenController::class, 'getToken']); 
    Route::get('/verify-token', [\App\Http\Controllers\Api\Self\AccesstokenController::class, 'verifyToken']);    

    /*
    |-------------------------------------------------------
    | TOKEN
    |-------------------------------------------------------
    */
    Route::post('/client-tracking-init-traffic-details', [\App\Http\Controllers\Api\ClientTracking\InitTrafficDetailsController::class, 'store']);

    /*
    |-------------------------------------------------------
    | TOKEN
    |-------------------------------------------------------
    */
    Route::post('/client-tracking-init-traffic-ads', [\App\Http\Controllers\Api\ClientTracking\InitTrafficAdsController::class, 'store']);
});




