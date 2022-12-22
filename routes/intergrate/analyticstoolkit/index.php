<?php
	
    /*
    |-------------------------------------------------------
    | ANALYTICS TOOLKIT
    |-------------------------------------------------------
    */
    /**analyticstoolkit*/
    Route::get('/analyticstoolkit/cpanel', 
        [\App\Http\Controllers\Backend\Intergrate\Analyticstoolkit\AnalyticstookitController::class, 'cpanel'])
    ->middleware('auth:admin');