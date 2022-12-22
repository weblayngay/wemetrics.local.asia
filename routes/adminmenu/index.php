<?php

	/*
	|-------------------------------------------------------
	| ADMIN MENU
	|-------------------------------------------------------
	*/
    Route::get('/adminmenu/index', [\App\Http\Controllers\Backend\AdminmenuController::class, 'index'])->middleware('auth:admin');
    Route::get('/adminmenu/detail', [\App\Http\Controllers\Backend\AdminmenuController::class, 'detail'])->middleware('auth:admin');
    Route::post('/adminmenu/active', [\App\Http\Controllers\Backend\AdminmenuController::class, 'active'])->middleware('auth:admin');
    Route::post('/adminmenu/inactive', [\App\Http\Controllers\Backend\AdminmenuController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/adminmenu/save', [\App\Http\Controllers\Backend\AdminmenuController::class, 'save'])->middleware('auth:admin');




