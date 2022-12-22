<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotviet*/
    Route::get('/kiotviet/cpanel', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\KiotvietController::class, 'cpanel'])
    ->middleware('auth:admin');