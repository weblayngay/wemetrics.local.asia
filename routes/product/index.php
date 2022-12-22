<?php

    /*
    |-------------------------------------------------------
    | PRODUCT
    |-------------------------------------------------------
    */
    /**product*/
    Route::post('/product/store', [\App\Http\Controllers\Backend\ProductController::class, 'store'])->middleware('auth:admin');
    Route::post('/product/update', [\App\Http\Controllers\Backend\ProductController::class, 'update'])->middleware('auth:admin');
    Route::post('/product/copy', [\App\Http\Controllers\Backend\ProductController::class, 'copy'])->middleware('auth:admin');
    Route::post('/product/duplicate', [\App\Http\Controllers\Backend\ProductController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/product/active', [\App\Http\Controllers\Backend\ProductController::class, 'active'])->middleware('auth:admin');
    Route::post('/product/inactive', [\App\Http\Controllers\Backend\ProductController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/product/delete', [\App\Http\Controllers\Backend\ProductController::class, 'delete'])->middleware('auth:admin');
    Route::get('/product/index', [\App\Http\Controllers\Backend\ProductController::class, 'index'])->middleware('auth:admin');
    Route::get('/product/create', [\App\Http\Controllers\Backend\ProductController::class, 'create'])->middleware('auth:admin');
    Route::get('/product/edit', [\App\Http\Controllers\Backend\ProductController::class, 'edit'])->middleware('auth:admin');