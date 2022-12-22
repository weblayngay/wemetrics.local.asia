<?php
	
    /*
    |-------------------------------------------------------
    | ADVERT
    |-------------------------------------------------------
    */
    /**advert*/
    Route::post('/advert/sort', [\App\Http\Controllers\Backend\AdvertController::class, 'sort'])->middleware('auth:admin');
    Route::post('/advert/store', [\App\Http\Controllers\Backend\AdvertController::class, 'store'])->middleware('auth:admin');
    Route::post('/advert/update', [\App\Http\Controllers\Backend\AdvertController::class, 'update'])->middleware('auth:admin');
    Route::post('/advert/copy', [\App\Http\Controllers\Backend\AdvertController::class, 'copy'])->middleware('auth:admin');
    Route::post('/advert/duplicate', [\App\Http\Controllers\Backend\AdvertController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/advert/active', [\App\Http\Controllers\Backend\AdvertController::class, 'active'])->middleware('auth:admin');
    Route::post('/advert/inactive', [\App\Http\Controllers\Backend\AdvertController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/advert/delete', [\App\Http\Controllers\Backend\AdvertController::class, 'delete'])->middleware('auth:admin');
    Route::get('/advert/index', [\App\Http\Controllers\Backend\AdvertController::class, 'index'])->middleware('auth:admin');
    Route::get('/advert/create', [\App\Http\Controllers\Backend\AdvertController::class, 'create'])->middleware('auth:admin');
    Route::get('/advert/edit', [\App\Http\Controllers\Backend\AdvertController::class, 'edit'])->middleware('auth:admin');    

    /**advert group */
    Route::post('/advertgroup/store', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'store'])->middleware('auth:admin');
    Route::post('/advertgroup/update', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'update'])->middleware('auth:admin');
    Route::post('/advertgroup/copy', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'copy'])->middleware('auth:admin');
    Route::post('/advertgroup/duplicate', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/advertgroup/active', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/advertgroup/inactive', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/advertgroup/delete', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'delete'])->middleware('auth:admin');
    Route::get('/advertgroup/index', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'index'])->middleware('auth:admin');
    Route::get('/advertgroup/drill', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'drill'])->middleware('auth:admin');    
    Route::get('/advertgroup/create', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'create'])->middleware('auth:admin');
    Route::get('/advertgroup/edit', [\App\Http\Controllers\Backend\AdvertgroupController::class, 'edit'])->middleware('auth:admin');



