<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietproductonhand */
    Route::get('/kiotvietproductonhand/getraw', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\ProductOnHand\KiotvietProductOnHandController::class, 'getRawProductOnHand'])
    ->middleware('auth:admin');