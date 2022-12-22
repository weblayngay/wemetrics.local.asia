<?php
	
    /*
    |-------------------------------------------------------
    | BANNER
    |-------------------------------------------------------
    */
    /**banner */
    Route::post('/banner/sort', [\App\Http\Controllers\Backend\BannerController::class, 'sort'])->middleware('auth:admin');
    Route::post('/banner/store', [\App\Http\Controllers\Backend\BannerController::class, 'store'])->middleware('auth:admin');
    Route::post('/banner/update', [\App\Http\Controllers\Backend\BannerController::class, 'update'])->middleware('auth:admin');
    Route::post('/banner/copy', [\App\Http\Controllers\Backend\BannerController::class, 'copy'])->middleware('auth:admin');
    Route::post('/banner/duplicate', [\App\Http\Controllers\Backend\BannerController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/banner/active', [\App\Http\Controllers\Backend\BannerController::class, 'active'])->middleware('auth:admin');
    Route::post('/banner/inactive', [\App\Http\Controllers\Backend\BannerController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/banner/delete', [\App\Http\Controllers\Backend\BannerController::class, 'delete'])->middleware('auth:admin');
    Route::get('/banner/index', [\App\Http\Controllers\Backend\BannerController::class, 'index'])->middleware('auth:admin');
    Route::get('/banner/create', [\App\Http\Controllers\Backend\BannerController::class, 'create'])->middleware('auth:admin');
    Route::get('/banner/edit', [\App\Http\Controllers\Backend\BannerController::class, 'edit'])->middleware('auth:admin');

    /**banner group */
    Route::post('/bannergroup/store', [\App\Http\Controllers\Backend\BannergroupController::class, 'store'])->middleware('auth:admin');
    Route::post('/bannergroup/update', [\App\Http\Controllers\Backend\BannergroupController::class, 'update'])->middleware('auth:admin');
    Route::post('/bannergroup/copy', [\App\Http\Controllers\Backend\BannergroupController::class, 'copy'])->middleware('auth:admin');
    Route::post('/bannergroup/duplicate', [\App\Http\Controllers\Backend\BannergroupController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/bannergroup/active', [\App\Http\Controllers\Backend\BannergroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/bannergroup/inactive', [\App\Http\Controllers\Backend\BannergroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/bannergroup/delete', [\App\Http\Controllers\Backend\BannergroupController::class, 'delete'])->middleware('auth:admin');
    Route::get('/bannergroup/index', [\App\Http\Controllers\Backend\BannergroupController::class, 'index'])->middleware('auth:admin');
    Route::get('/bannergroup/create', [\App\Http\Controllers\Backend\BannergroupController::class, 'create'])->middleware('auth:admin');
    Route::get('/bannergroup/edit', [\App\Http\Controllers\Backend\BannergroupController::class, 'edit'])->middleware('auth:admin');



