<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietpurchaseorder */
    Route::get('/kiotvietPurchaseorder/getraw', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\PurchaseOrder\KiotvietPurchaseOrderController::class, 'getRawPurchaseOrder'])
    ->middleware('auth:admin');

    Route::get('/kiotvietPurchaseorder/getrawbydate', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\PurchaseOrder\KiotvietPurchaseOrderController::class, 'getRawPurchaseOrderByDate'])
    ->middleware('auth:admin');

    Route::get('/kiotvietPurchaseorder/getrawbyproductbydate', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\PurchaseOrder\KiotvietPurchaseOrderController::class, 'getRawPurchaseOrderByProductByDate'])
    ->middleware('auth:admin');