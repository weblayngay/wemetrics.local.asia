<?php

    /*
    |-------------------------------------------------------
    | CONFIG
    |-------------------------------------------------------
    */
    Route::get('/config/index', [\App\Http\Controllers\Backend\ConfigController::class, 'index'])->middleware('auth:admin');
    Route::get('/config/detail', [\App\Http\Controllers\Backend\ConfigController::class, 'detail'])->middleware('auth:admin');
    Route::post('/config/save', [\App\Http\Controllers\Backend\ConfigController::class, 'save'])->middleware('auth:admin');
    Route::get('/config/savecache', [\App\Http\Controllers\Backend\ConfigController::class, 'saveCache'])->middleware('auth:admin');
    Route::get('/config/clearcache', [\App\Http\Controllers\Backend\ConfigController::class, 'clearCache'])->middleware('auth:admin');



