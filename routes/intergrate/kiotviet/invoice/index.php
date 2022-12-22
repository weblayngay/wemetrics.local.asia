<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietinvoice */
    Route::get('/kiotvietInvoice/getraw', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoice'])
    ->middleware('auth:admin');

    // By Status
    Route::get(
        '/kiotvietInvoice/getrawbystatus'.'/{status}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByStatus'])
    ->middleware('auth:admin');

    // By BranchIds
    Route::get(
        '/kiotvietInvoice/getrawbybranchId'.'/{status}'.'/{branchIds}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByBranchId'])
    ->middleware('auth:admin');

    // By CustomerIds
    Route::get(
        '/kiotvietInvoice/getrawbycustomerId'.'/{status}'.'/{customerIds}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByCustomerId'])
    ->middleware('auth:admin');

    // By CustomerCode
    Route::get(
        '/kiotvietInvoice/getrawbycustomercode'.'/{status}'.'/{customerCode}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByCustomerCode'])
    ->middleware('auth:admin');

    // By OrderIds
    Route::get(
        '/kiotvietInvoice/getrawbyorderId'.'/{status}'.'/{orderIds}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByOrderId'])
    ->middleware('auth:admin');

    // Completed
    Route::get(
        '/kiotvietInvoice/getrawcompleted', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawCompletedInvoice'])
    ->middleware('auth:admin');

    // Canceled
    Route::get(
        '/kiotvietInvoice/getrawcanceled', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawCanceledInvoice'])
    ->middleware('auth:admin');

    // Ongoing
    Route::get(
        '/kiotvietInvoice/getrawongoing', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawOngoingInvoice'])
    ->middleware('auth:admin');

    // CantDelivery
    Route::get(
        '/kiotvietInvoice/getrawcantdelivery', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawCantDeliveryInvoice'])
    ->middleware('auth:admin');

    // By Todate
    Route::get(
        '/kiotvietInvoice/getrawbytodate'.'/{status}'.'/{toDate}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByToDate'])
    ->middleware('auth:admin');

    // From Purchase Date To Purchase Date
    Route::get(
        '/kiotvietInvoice/getrawbypurchasedate'.'/{status}'.'/{frmPurDate}'.'/{toPurDate}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceByPurchaseDate'])
    ->middleware('auth:admin');

    /**kiotvietinvoicedetail */
    Route::get('/kiotvietInvoice/getrawbyid'.'/{id}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceDetailById'])
    ->middleware('auth:admin');

    Route::get('/kiotvietInvoice/getrawbycode'.'/{code}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'getRawInvoiceDetailByCode'])
    ->middleware('auth:admin');

    Route::get('/kiotvietInvoice/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'preloadindex'])
    ->middleware('auth:admin');

    Route::get('/kiotvietInvoice/index', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietInvoice/preloadsearch', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'preloadsearch'])
    ->middleware('auth:admin');
    //
    Route::post('/kiotvietInvoice/search', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'search'])
    ->middleware('auth:admin');

    Route::get('/kiotvietInvoice/paginate', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'search'])
    ->middleware('auth:admin');
    //
    Route::get('/kiotvietInvoice/edit', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController::class, 'edit'])
    ->middleware('auth:admin');