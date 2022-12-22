<?php
	
    /*
    |-------------------------------------------------------
    | USER
    |-------------------------------------------------------
    */
    /** user */
    Route::post('/user/store', [\App\Http\Controllers\Backend\UserController::class, 'store'])->middleware('auth:admin');
    Route::post('/user/active', [\App\Http\Controllers\Backend\UserController::class, 'active'])->middleware('auth:admin');
    Route::post('/user/inactive', [\App\Http\Controllers\Backend\UserController::class, 'inactive'])->middleware('auth:admin');
    Route::get('/user/index', [\App\Http\Controllers\Backend\UserController::class, 'index'])->middleware('auth:admin');
    Route::get('/user/edit', [\App\Http\Controllers\Backend\UserController::class, 'edit'])->middleware('auth:admin');
    Route::post('/user/update', [\App\Http\Controllers\Backend\UserController::class, 'update'])->middleware('auth:admin');
    Route::post('/user/delete', [\App\Http\Controllers\Backend\UserController::class, 'delete'])->middleware('auth:admin');
    Route::get('/user/get-user-district', [\App\Http\Controllers\Backend\UserController::class, 'getDistrict'])->name('get-user-district');
    Route::get('/user/get-user-ward', [\App\Http\Controllers\Backend\UserController::class, 'getWard'])->name('get-user-ward');



