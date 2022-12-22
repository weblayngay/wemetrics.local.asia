<?php
	
    /*
    |-------------------------------------------------------
    | POST
    |-------------------------------------------------------
    */
    /**post */
    Route::post('/post/store', [\App\Http\Controllers\Backend\PostController::class, 'store'])->middleware('auth:admin');
    Route::post('/post/update', [\App\Http\Controllers\Backend\PostController::class, 'update'])->middleware('auth:admin');
    Route::post('/post/copy', [\App\Http\Controllers\Backend\PostController::class, 'copy'])->middleware('auth:admin');
    Route::post('/post/duplicate', [\App\Http\Controllers\Backend\PostController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/post/active', [\App\Http\Controllers\Backend\PostController::class, 'active'])->middleware('auth:admin');
    Route::post('/post/inactive', [\App\Http\Controllers\Backend\PostController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/post/delete', [\App\Http\Controllers\Backend\PostController::class, 'delete'])->middleware('auth:admin');
    Route::get('/post/index', [\App\Http\Controllers\Backend\PostController::class, 'index'])->middleware('auth:admin');
    Route::get('/post/create', [\App\Http\Controllers\Backend\PostController::class, 'create'])->middleware('auth:admin');
    Route::get('/post/edit', [\App\Http\Controllers\Backend\PostController::class, 'edit'])->middleware('auth:admin');

    /**post group */
    Route::post('/postgroup/store', [\App\Http\Controllers\Backend\PostgroupController::class, 'store'])->middleware('auth:admin');
    Route::post('/postgroup/update', [\App\Http\Controllers\Backend\PostgroupController::class, 'update'])->middleware('auth:admin');
    Route::post('/postgroup/copy', [\App\Http\Controllers\Backend\PostgroupController::class, 'copy'])->middleware('auth:admin');
    Route::post('/postgroup/duplicate', [\App\Http\Controllers\Backend\PostgroupController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/postgroup/active', [\App\Http\Controllers\Backend\PostgroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/postgroup/inactive', [\App\Http\Controllers\Backend\PostgroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/postgroup/delete', [\App\Http\Controllers\Backend\PostgroupController::class, 'delete'])->middleware('auth:admin');
    Route::get('/postgroup/index', [\App\Http\Controllers\Backend\PostgroupController::class, 'index'])->middleware('auth:admin');
    Route::get('/postgroup/drill', [\App\Http\Controllers\Backend\PostgroupController::class, 'drill'])->middleware('auth:admin');
    Route::get('/postgroup/create', [\App\Http\Controllers\Backend\PostgroupController::class, 'create'])->middleware('auth:admin');
    Route::get('/postgroup/edit', [\App\Http\Controllers\Backend\PostgroupController::class, 'edit'])->middleware('auth:admin');



