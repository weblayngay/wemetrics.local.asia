<?php

	/*
	|-------------------------------------------------------
	| ADMIN USER
	|-------------------------------------------------------
	*/
	Route::get('/adminuser/index', [\App\Http\Controllers\Backend\AdminuserController::class, 'index'])->middleware('auth:admin');
	Route::get('/adminuser/detail', [\App\Http\Controllers\Backend\AdminuserController::class, 'detail'])->middleware('auth:admin');
	Route::post('/adminuser/active', [\App\Http\Controllers\Backend\AdminuserController::class, 'active'])->middleware('auth:admin');
	Route::post('/adminuser/inactive', [\App\Http\Controllers\Backend\AdminuserController::class, 'inactive'])->middleware('auth:admin');
	Route::post('/adminuser/save', [\App\Http\Controllers\Backend\AdminuserController::class, 'save'])->middleware('auth:admin');
	Route::post('/adminuser/delete', [\App\Http\Controllers\Backend\AdminuserController::class, 'delete'])->middleware('auth:admin');




