<?php
	
    /*
    |-------------------------------------------------------
    | DASHBOARD
    |-------------------------------------------------------
    */
    Route::get('/index/index', [\App\Http\Controllers\Backend\IndexController::class, 'index'])->name('admins.dashboard')->middleware('auth:admin');
    // Route::get('', [\App\Http\Controllers\Backend\IndexController::class, 'index'])->name(ADMIN_ROUTE . '.dashboard')->middleware('auth:admin');



