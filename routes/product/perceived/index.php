<?php

    /*
    |-------------------------------------------------------
    | PERCEIVED VALUE
    |-------------------------------------------------------
    */
    Route::post('/perceivedvalue/store', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'store'])->middleware('auth:admin');
    Route::post('/perceivedvalue/update', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'update'])->middleware('auth:admin');
    Route::post('/perceivedvalue/copy', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'copy'])->middleware('auth:admin');
    Route::post('/perceivedvalue/duplicate', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/perceivedvalue/active', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'active'])->middleware('auth:admin');
    Route::post('/perceivedvalue/inactive', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/perceivedvalue/delete', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'delete'])->middleware('auth:admin');
    Route::get('/perceivedvalue/index', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'index'])->middleware('auth:admin');
    Route::get('/perceivedvalue/create', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'create'])->middleware('auth:admin');
    Route::get('/perceivedvalue/edit', [\App\Http\Controllers\Backend\PerceivedValueController::class, 'edit'])->middleware('auth:admin');



