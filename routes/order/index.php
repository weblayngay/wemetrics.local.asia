<?php
	
    /*
    |-------------------------------------------------------
    | ORDER
    |-------------------------------------------------------
    */
    /**order*/
    Route::post('/order/update', [\App\Http\Controllers\Backend\Order\OrderController::class, 'update'])->middleware('auth:admin');
    Route::post('/order/delete', [\App\Http\Controllers\Backend\Order\OrderController::class, 'delete'])->middleware('auth:admin');
    Route::get('/order/index', [\App\Http\Controllers\Backend\Order\OrderController::class, 'index'])->middleware('auth:admin');
    Route::get('/order/edit', [\App\Http\Controllers\Backend\Order\OrderController::class, 'edit'])->middleware('auth:admin');
    Route::post('/order/exportOrder', [\App\Http\Controllers\Backend\Order\OrderController::class, 'exportOrder'])->middleware('auth:admin');
    Route::post('/order/exportCustomer', [\App\Http\Controllers\Backend\Order\OrderController::class, 'exportCustomer'])->middleware('auth:admin');
    Route::post('/order/search', [\App\Http\Controllers\Backend\Order\OrderController::class, 'search'])->middleware('auth:admin');
    Route::get('/order/paginate', [\App\Http\Controllers\Backend\Order\OrderController::class, 'search'])->middleware('auth:admin');
    /*
    |-------------------------------------------------------
    | ORDER WEBSITE REPORT
    |-------------------------------------------------------
    */
    /**orderwebsitereportoverview */
    Route::get('/orderwebsitereportoverview/index', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportOverviewController::class, 'index'])->middleware('auth:admin');
    Route::post('/orderwebsitereportoverview/stats', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportOverviewController::class, 'stats'])->middleware('auth:admin');

    /**orderwebsitereportreseller */
    Route::get('/orderwebsitereportreseller/index', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportResellerController::class, 'index'])->middleware('auth:admin');
    Route::post('/orderwebsitereportreseller/stats', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportResellerController::class, 'stats'])->middleware('auth:admin');

    /**orderwebsitereportpayonline */
    Route::get('/orderwebsitereportpayonline/index', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportPayOnlineController::class, 'index'])->middleware('auth:admin');
    Route::post('/orderwebsitereportpayonline/stats', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportPayOnlineController::class, 'stats'])->middleware('auth:admin');

    /**orderwebsitereportproduct */
    Route::get('/orderwebsitereportproduct/index', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportProductController::class, 'index'])->middleware('auth:admin');
    Route::post('/orderwebsitereportproduct/stats', [\App\Http\Controllers\Backend\Order\Report\OrderWebsiteReportProductController::class, 'stats'])->middleware('auth:admin');



