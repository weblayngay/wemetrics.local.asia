<?php

    /*
    |-------------------------------------------------------
    | CTOKEN VENDOR
    |-------------------------------------------------------
    */
    /**ctoken vendor */
    Route::post('/ctokenvendor/store', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'store'])->middleware('auth:admin');
    Route::post('/ctokenvendor/update', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'update'])->middleware('auth:admin');
    Route::post('/ctokenvendor/copy', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'copy'])->middleware('auth:admin');
    Route::post('/ctokenvendor/duplicate', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/ctokenvendor/active', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'active'])->middleware('auth:admin');
    Route::post('/ctokenvendor/inactive', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/ctokenvendor/delete', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'delete'])->middleware('auth:admin');
    Route::post('/ctokenvendor/search', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'search'])->middleware('auth:admin');
    Route::get('/ctokenvendor/index', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'index'])->middleware('auth:admin');
    Route::get('/ctokenvendor/cpanel', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/ctokenvendor/create', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'create'])->middleware('auth:admin');
    Route::get('/ctokenvendor/edit', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenvendorController::class, 'edit'])->middleware('auth:admin');


