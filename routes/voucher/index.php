<?php
	
    /*
    |-------------------------------------------------------
    | VOUCHER
    |-------------------------------------------------------
    */
    /**voucher */
    Route::post('/voucher/store', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'store'])->middleware('auth:admin');
    Route::post('/voucher/update', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'update'])->middleware('auth:admin');
    Route::post('/voucher/copy', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'copy'])->middleware('auth:admin');
    Route::post('/voucher/duplicate', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/voucher/active', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'active'])->middleware('auth:admin');
    Route::post('/voucher/inactive', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/voucher/delete', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'delete'])->middleware('auth:admin');
    //
    Route::post('/voucher/search', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'search'])->middleware('auth:admin');
    Route::get('/voucher/paginate', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'search'])->middleware('auth:admin');
    //
    Route::get('/voucher/index', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'index'])->middleware('auth:admin');
    Route::get('/voucher/create', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'create'])->middleware('auth:admin');
    Route::get('/voucher/edit', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'edit'])->middleware('auth:admin');
    Route::get('/voucher/synchro', [\App\Http\Controllers\Backend\Voucher\VoucherController::class, 'synchro'])->middleware('auth:admin');

    /**voucher group */
    Route::post('/vouchergroup/store', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'store'])->middleware('auth:admin');
    Route::post('/vouchergroup/update', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'update'])->middleware('auth:admin');
    Route::post('/vouchergroup/copy', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'copy'])->middleware('auth:admin');
    Route::post('/vouchergroup/duplicate', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/vouchergroup/active', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/vouchergroup/inactive', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/vouchergroup/delete', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'delete'])->middleware('auth:admin');
    Route::post('/vouchergroup/search', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'search'])->middleware('auth:admin');
    Route::get('/vouchergroup/index', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'index'])->middleware('auth:admin');
    Route::get('/vouchergroup/create', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'create'])->middleware('auth:admin');
    Route::get('/vouchergroup/edit', [\App\Http\Controllers\Backend\Voucher\VouchergroupController::class, 'edit'])->middleware('auth:admin');



