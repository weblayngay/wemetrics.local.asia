<?php
	
    /*
    |-------------------------------------------------------
    | MENU
    |-------------------------------------------------------
    */
    /**menu group */
    Route::post('/menugroup/store', [\App\Http\Controllers\Backend\MenugroupController::class, 'store'])->middleware('auth:admin');
    Route::post('/menugroup/update', [\App\Http\Controllers\Backend\MenugroupController::class, 'update'])->middleware('auth:admin');
    Route::post('/menugroup/active', [\App\Http\Controllers\Backend\MenugroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/menugroup/inactive', [\App\Http\Controllers\Backend\MenugroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/menugroup/delete', [\App\Http\Controllers\Backend\MenugroupController::class, 'delete'])->middleware('auth:admin');
    Route::get('/menugroup/index', [\App\Http\Controllers\Backend\MenugroupController::class, 'index'])->middleware('auth:admin');
    Route::get('/menugroup/create', [\App\Http\Controllers\Backend\MenugroupController::class, 'create'])->middleware('auth:admin');
    Route::get('/menugroup/edit', [\App\Http\Controllers\Backend\MenugroupController::class, 'edit'])->middleware('auth:admin');

    /** menu */
    Route::post('/menu/sort', [\App\Http\Controllers\Backend\MenuController::class, 'sort'])->middleware('auth:admin');
    Route::post('/menu/store', [\App\Http\Controllers\Backend\MenuController::class, 'store'])->middleware('auth:admin');
    Route::post('/menu/update', [\App\Http\Controllers\Backend\MenuController::class, 'update'])->middleware('auth:admin');
    Route::post('/menu/copy', [\App\Http\Controllers\Backend\MenuController::class, 'copy'])->middleware('auth:admin');
    Route::post('/menu/duplicate', [\App\Http\Controllers\Backend\MenuController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/menu/active', [\App\Http\Controllers\Backend\MenuController::class, 'active'])->middleware('auth:admin');
    Route::post('/menu/inactive', [\App\Http\Controllers\Backend\MenuController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/menu/delete', [\App\Http\Controllers\Backend\MenuController::class, 'delete'])->middleware('auth:admin');
    Route::get('/menu/index', [\App\Http\Controllers\Backend\MenuController::class, 'index'])->middleware('auth:admin');
    Route::get('/menu/create', [\App\Http\Controllers\Backend\MenuController::class, 'create'])->middleware('auth:admin');
    Route::get('/menu/edit', [\App\Http\Controllers\Backend\MenuController::class, 'edit'])->middleware('auth:admin');



