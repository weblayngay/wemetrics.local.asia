<?php

    /*
    |-------------------------------------------------------
    | CTOKEN OUT
    |-------------------------------------------------------
    */
    /**ctoken out */
    Route::post('/ctokenout/store', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'store'])->middleware('auth:admin');
    Route::post('/ctokenout/update', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'update'])->middleware('auth:admin');
    Route::post('/ctokenout/copy', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'copy'])->middleware('auth:admin');
    Route::post('/ctokenout/duplicate', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/ctokenout/active', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'active'])->middleware('auth:admin');
    Route::post('/ctokenout/inactive', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/ctokenout/delete', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'delete'])->middleware('auth:admin');
    Route::post('/ctokenout/search', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'search'])->middleware('auth:admin');
    Route::get('/ctokenout/index', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'index'])->middleware('auth:admin');
    Route::get('/ctokenout/cpanel', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/ctokenout/create', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'create'])->middleware('auth:admin');
    Route::get('/ctokenout/edit', [\App\Http\Controllers\Backend\Intergrate\ApiOut\CtokenoutController::class, 'edit'])->middleware('auth:admin');


