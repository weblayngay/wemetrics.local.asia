<?php

    /*
    |-------------------------------------------------------
    | NUTRITIONS
    |-------------------------------------------------------
    */
    /**nutritions*/
    Route::post('/productnutritions/store', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'store'])->middleware('auth:admin');
    Route::post('/productnutritions/update', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'update'])->middleware('auth:admin');
    Route::post('/productnutritions/copy', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'copy'])->middleware('auth:admin');
    Route::post('/productnutritions/duplicate', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/productnutritions/active', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'active'])->middleware('auth:admin');
    Route::post('/productnutritions/inactive', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/productnutritions/delete', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'delete'])->middleware('auth:admin');
    Route::get('/productnutritions/index', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'index'])->middleware('auth:admin');
    Route::get('/productnutritions/create', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'create'])->middleware('auth:admin');
    Route::get('/productnutritions/edit', [\App\Http\Controllers\Backend\ProductNutritionsController::class, 'edit'])->middleware('auth:admin');



