<?php

    /*
    |-------------------------------------------------------
    | PRODUCER
    |-------------------------------------------------------
    */
    /**producer */
    Route::post('/producer/sort', [\App\Http\Controllers\Backend\ProducerController::class, 'sort'])->middleware('auth:admin');
    Route::post('/producer/store', [\App\Http\Controllers\Backend\ProducerController::class, 'store'])->middleware('auth:admin');
    Route::post('/producer/update', [\App\Http\Controllers\Backend\ProducerController::class, 'update'])->middleware('auth:admin');
    Route::post('/producer/copy', [\App\Http\Controllers\Backend\ProducerController::class, 'copy'])->middleware('auth:admin');
    Route::post('/producer/duplicate', [\App\Http\Controllers\Backend\ProducerController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/producer/active', [\App\Http\Controllers\Backend\ProducerController::class, 'active'])->middleware('auth:admin');
    Route::post('/producer/inactive', [\App\Http\Controllers\Backend\ProducerController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/producer/delete', [\App\Http\Controllers\Backend\ProducerController::class, 'delete'])->middleware('auth:admin');
    Route::get('/producer/index', [\App\Http\Controllers\Backend\ProducerController::class, 'index'])->middleware('auth:admin');
    Route::get('/producer/create', [\App\Http\Controllers\Backend\ProducerController::class, 'create'])->middleware('auth:admin');
    Route::get('/producer/edit', [\App\Http\Controllers\Backend\ProducerController::class, 'edit'])->middleware('auth:admin');



