<?php

    /*
    |-------------------------------------------------------
    | COLLECTION
    |-------------------------------------------------------
    */
    /**collection*/
    Route::post('/productcollection/store', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'store'])->middleware('auth:admin');
    Route::post('/productcollection/update', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'update'])->middleware('auth:admin');
    Route::post('/productcollection/copy', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'copy'])->middleware('auth:admin');
    Route::post('/productcollection/duplicate', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/productcollection/active', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'active'])->middleware('auth:admin');
    Route::post('/productcollection/inactive', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/productcollection/delete', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'delete'])->middleware('auth:admin');
    Route::get('/productcollection/index', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'index'])->middleware('auth:admin');
    Route::get('/productcollection/create', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'create'])->middleware('auth:admin');
    Route::get('/productcollection/edit', [\App\Http\Controllers\Backend\ProductCollectionController::class, 'edit'])->middleware('auth:admin');



