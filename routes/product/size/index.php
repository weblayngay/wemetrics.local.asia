<?php

    /*
    |-------------------------------------------------------
    | SIZE
    |-------------------------------------------------------
    */
    /**size*/
    Route::post('/productsize/store', [\App\Http\Controllers\Backend\ProductSizeController::class, 'store'])->middleware('auth:admin');
    Route::post('/productsize/update', [\App\Http\Controllers\Backend\ProductSizeController::class, 'update'])->middleware('auth:admin');
    Route::post('/productsize/copy', [\App\Http\Controllers\Backend\ProductSizeController::class, 'copy'])->middleware('auth:admin');
    Route::post('/productsize/duplicate', [\App\Http\Controllers\Backend\ProductSizeController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/productsize/active', [\App\Http\Controllers\Backend\ProductSizeController::class, 'active'])->middleware('auth:admin');
    Route::post('/productsize/inactive', [\App\Http\Controllers\Backend\ProductSizeController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/productsize/delete', [\App\Http\Controllers\Backend\ProductSizeController::class, 'delete'])->middleware('auth:admin');
    Route::get('/productsize/index', [\App\Http\Controllers\Backend\ProductSizeController::class, 'index'])->middleware('auth:admin');
    Route::get('/productsize/create', [\App\Http\Controllers\Backend\ProductSizeController::class, 'create'])->middleware('auth:admin');
    Route::get('/productsize/edit', [\App\Http\Controllers\Backend\ProductSizeController::class, 'edit'])->middleware('auth:admin');



