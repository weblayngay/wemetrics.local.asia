<?php
	
    /*
    |-------------------------------------------------------
    | CONTACT
    |-------------------------------------------------------
    /**contact*/
    Route::post('/contact/store', [\App\Http\Controllers\Backend\ContactController::class, 'store'])->middleware('auth:admin');
    Route::post('/contact/update', [\App\Http\Controllers\Backend\ContactController::class, 'update'])->middleware('auth:admin');
    Route::post('/contact/copy', [\App\Http\Controllers\Backend\ContactController::class, 'copy'])->middleware('auth:admin');
    Route::post('/contact/duplicate', [\App\Http\Controllers\Backend\ContactController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/contact/active', [\App\Http\Controllers\Backend\ContactController::class, 'active'])->middleware('auth:admin');
    Route::post('/contact/inactive', [\App\Http\Controllers\Backend\ContactController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/contact/delete', [\App\Http\Controllers\Backend\ContactController::class, 'delete'])->middleware('auth:admin');
    Route::get('/contact/index', [\App\Http\Controllers\Backend\ContactController::class, 'index'])->middleware('auth:admin');
    Route::get('/contact/create', [\App\Http\Controllers\Backend\ContactController::class, 'create'])->middleware('auth:admin');
    Route::get('/contact/edit', [\App\Http\Controllers\Backend\ContactController::class, 'edit'])->middleware('auth:admin');

    /**contactconfig*/
    Route::post('/contactconfig/store', [\App\Http\Controllers\Backend\ContactConfigController::class, 'store'])->middleware('auth:admin');
    Route::post('/contactconfig/update', [\App\Http\Controllers\Backend\ContactConfigController::class, 'update'])->middleware('auth:admin');
    Route::post('/contactconfig/active', [\App\Http\Controllers\Backend\ContactConfigController::class, 'active'])->middleware('auth:admin');
    Route::post('/contactconfig/inactive', [\App\Http\Controllers\Backend\ContactConfigController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/contactconfig/delete', [\App\Http\Controllers\Backend\ContactConfigController::class, 'delete'])->middleware('auth:admin');
    Route::get('/contactconfig/index', [\App\Http\Controllers\Backend\ContactConfigController::class, 'index'])->middleware('auth:admin');
    Route::get('/contactconfig/create', [\App\Http\Controllers\Backend\ContactConfigController::class, 'create'])->middleware('auth:admin');
    Route::get('/contactconfig/edit', [\App\Http\Controllers\Backend\ContactConfigController::class, 'edit'])->middleware('auth:admin');

    /**contactextend*/
    Route::post('/contactextend/sort', [\App\Http\Controllers\Backend\ContactExtendController::class, 'sort'])->middleware('auth:admin');
    Route::post('/contactextend/store', [\App\Http\Controllers\Backend\ContactExtendController::class, 'store'])->middleware('auth:admin');
    Route::post('/contactextend/update', [\App\Http\Controllers\Backend\ContactExtendController::class, 'update'])->middleware('auth:admin');
    Route::post('/contactextend/copy', [\App\Http\Controllers\Backend\ContactExtendController::class, 'copy'])->middleware('auth:admin');
    Route::post('/contactextend/duplicate', [\App\Http\Controllers\Backend\ContactExtendController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/contactextend/active', [\App\Http\Controllers\Backend\ContactExtendController::class, 'active'])->middleware('auth:admin');
    Route::post('/contactextend/inactive', [\App\Http\Controllers\Backend\ContactExtendController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/contactextend/delete', [\App\Http\Controllers\Backend\ContactExtendController::class, 'delete'])->middleware('auth:admin');
    Route::get('/contactextend/index', [\App\Http\Controllers\Backend\ContactExtendController::class, 'index'])->middleware('auth:admin');
    Route::get('/contactextend/create', [\App\Http\Controllers\Backend\ContactExtendController::class, 'create'])->middleware('auth:admin');
    Route::get('/contactextend/edit', [\App\Http\Controllers\Backend\ContactExtendController::class, 'edit'])->middleware('auth:admin');  



