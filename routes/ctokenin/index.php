<?php

    /*
    |-------------------------------------------------------
    | CTOKEN IN
    |-------------------------------------------------------
    */
    /**ctoken in */
    Route::post('/ctokenin/store', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'store'])->middleware('auth:admin');
    Route::post('/ctokenin/update', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'update'])->middleware('auth:admin');
    Route::post('/ctokenin/copy', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'copy'])->middleware('auth:admin');
    Route::post('/ctokenin/duplicate', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/ctokenin/active', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'active'])->middleware('auth:admin');
    Route::post('/ctokenin/inactive', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/ctokenin/delete', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'delete'])->middleware('auth:admin');
    Route::post('/ctokenin/search', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'search'])->middleware('auth:admin');
    Route::get('/ctokenin/index', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'index'])->middleware('auth:admin');
    Route::get('/ctokenin/cpanel', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/ctokenin/create', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'create'])->middleware('auth:admin');
    Route::get('/ctokenin/edit', [\App\Http\Controllers\Backend\Intergrate\ApiIn\CtokeninController::class, 'edit'])->middleware('auth:admin');


