<?php

	/*
	|-------------------------------------------------------
	| ADMIN GROUP
	|-------------------------------------------------------
	*/
    Route::post('/admingroup/active', [\App\Http\Controllers\Backend\AdmingroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/admingroup/inactive', [\App\Http\Controllers\Backend\AdmingroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/admingroup/delete', [\App\Http\Controllers\Backend\AdmingroupController::class, 'delete'])->middleware('auth:admin');
    Route::post('/admingroup/save', [\App\Http\Controllers\Backend\AdmingroupController::class, 'save'])->middleware('auth:admin');




