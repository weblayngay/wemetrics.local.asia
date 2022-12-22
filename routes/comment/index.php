<?php
	
    /*
    |-------------------------------------------------------
    | COMMENT
    |-------------------------------------------------------
    */
    /**comment */
    Route::post('/comment/store', [\App\Http\Controllers\Backend\CommentController::class, 'store'])->middleware('auth:admin');
    Route::post('/comment/update', [\App\Http\Controllers\Backend\CommentController::class, 'update'])->middleware('auth:admin');
    Route::post('/comment/active', [\App\Http\Controllers\Backend\CommentController::class, 'active'])->middleware('auth:admin');
    Route::post('/comment/inactive', [\App\Http\Controllers\Backend\CommentController::class, 'inactive'])->middleware('auth:admin');
    Route::get('/comment/index', [\App\Http\Controllers\Backend\CommentController::class, 'index'])->middleware('auth:admin');
    Route::get('/comment/edit', [\App\Http\Controllers\Backend\CommentController::class, 'edit'])->middleware('auth:admin');



