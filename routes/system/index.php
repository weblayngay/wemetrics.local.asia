<?php

    /*
    |-------------------------------------------------------
    | SYSTEM
    |-------------------------------------------------------
    */
    Route::get('/system/configcache', [\App\Http\Controllers\Backend\SystemController::class, 'configCache'])->middleware('auth:admin');
    Route::get('/system/configclear', [\App\Http\Controllers\Backend\SystemController::class, 'configClear'])->middleware('auth:admin');


