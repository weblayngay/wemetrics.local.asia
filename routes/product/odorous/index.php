<?php

    /*
    |-------------------------------------------------------
    | ODOROUS
    |-------------------------------------------------------
    */
    /**odorous*/
    Route::post('/productodorous/store', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'store'])->middleware('auth:admin');
    Route::post('/productodorous/update', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'update'])->middleware('auth:admin');
    Route::post('/productodorous/copy', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'copy'])->middleware('auth:admin');
    Route::post('/productodorous/duplicate', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/productodorous/active', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'active'])->middleware('auth:admin');
    Route::post('/productodorous/inactive', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/productodorous/delete', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'delete'])->middleware('auth:admin');
    Route::get('/productodorous/index', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'index'])->middleware('auth:admin');
    Route::get('/productodorous/create', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'create'])->middleware('auth:admin');
    Route::get('/productodorous/edit', [\App\Http\Controllers\Backend\ProductOdorousController::class, 'edit'])->middleware('auth:admin');



