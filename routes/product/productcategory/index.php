<?php

    /*
    |-------------------------------------------------------
    | PRODUCT CATEGORY
    |-------------------------------------------------------
    */
    Route::get('/productcategory/index', [\App\Http\Controllers\Backend\ProductcategoryController::class, 'index'])->middleware('auth:admin');
    Route::get('/productcategory/type', [\App\Http\Controllers\Backend\ProductcategoryController::class, 'type'])->middleware('auth:admin');
    Route::get('/productcategory/detail', [\App\Http\Controllers\Backend\ProductcategoryController::class, 'detail'])->middleware('auth:admin');
    Route::get('/productcategory/delete', [\App\Http\Controllers\Backend\ProductcategoryController::class, 'delete'])->middleware('auth:admin');
    Route::post('/productcategory/save', [\App\Http\Controllers\Backend\ProductcategoryController::class, 'save'])->middleware('auth:admin');




