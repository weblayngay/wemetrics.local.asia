<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietcustomer */
    Route::get('/kiotvietCustomer/getrawbyid'.'/{id}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'getRawCustomerById'])
    ->middleware('auth:admin');

    Route::get('/kiotvietCustomer/getrawbycode'.'/{code}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'getRawCustomerByCode'])
    ->middleware('auth:admin');

    Route::get('/kiotvietCustomer/getrawcustomer', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'getRawCustomer'])
    ->middleware('auth:admin');

    Route::get('/kiotvietCustomer/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'preloadindex'])
    ->middleware('auth:admin');
    
    Route::get('/kiotvietCustomer/index', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietCustomer/preloadsearch', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'preloadsearch'])
    ->middleware('auth:admin');

    Route::post('/kiotvietCustomer/search', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'search'])
    ->middleware('auth:admin');

    Route::get('/kiotvietCustomer/paginate', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'search'])
    ->middleware('auth:admin');

    Route::get('/kiotvietCustomer/edit', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer\KiotvietCustomerController::class, 'edit'])
    ->middleware('auth:admin');