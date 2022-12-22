<?php

    /*
    |-------------------------------------------------------
    | COLOR
    |-------------------------------------------------------
    */
    /**color*/
    Route::post('/productcolor/store', [\App\Http\Controllers\Backend\ProductColorController::class, 'store'])->middleware('auth:admin');
    Route::post('/productcolor/update', [\App\Http\Controllers\Backend\ProductColorController::class, 'update'])->middleware('auth:admin');
    Route::post('/productcolor/copy', [\App\Http\Controllers\Backend\ProductColorController::class, 'copy'])->middleware('auth:admin');
    Route::post('/productcolor/duplicate', [\App\Http\Controllers\Backend\ProductColorController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/productcolor/active', [\App\Http\Controllers\Backend\ProductColorController::class, 'active'])->middleware('auth:admin');
    Route::post('/productcolor/inactive', [\App\Http\Controllers\Backend\ProductColorController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/productcolor/delete', [\App\Http\Controllers\Backend\ProductColorController::class, 'delete'])->middleware('auth:admin');
    Route::get('/productcolor/index', [\App\Http\Controllers\Backend\ProductColorController::class, 'index'])->middleware('auth:admin');
    Route::get('/productcolor/create', [\App\Http\Controllers\Backend\ProductColorController::class, 'create'])->middleware('auth:admin');
    Route::get('/productcolor/edit', [\App\Http\Controllers\Backend\ProductColorController::class, 'edit'])->middleware('auth:admin');
    Route::get('/productcolor/list', [\App\Http\Controllers\Backend\ProductColorController::class, 'list'])->middleware('auth:admin');



