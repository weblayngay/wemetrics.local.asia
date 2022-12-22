<?php

    /*
    |-------------------------------------------------------
    | BLOCK
    |-------------------------------------------------------
    */
    Route::get('/block/index', [\App\Http\Controllers\Backend\BlockController::class, 'index'])->middleware('auth:admin');
    Route::post('/block/inactive', [\App\Http\Controllers\Backend\BlockController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/block/active', [\App\Http\Controllers\Backend\BlockController::class, 'active'])->middleware('auth:admin');
    Route::post('/block/sort', [\App\Http\Controllers\Backend\BlockController::class, 'sort'])->middleware('auth:admin');



