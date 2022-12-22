<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietbranch */
    Route::get('/kiotvietbranch/getraw', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch\KiotvietBranchController::class, 'getRawBranch'])
    ->middleware('auth:admin');

    Route::get('/kiotvietbranch/getrawbycode'.'/{code}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch\KiotvietBranchController::class, 'getBranchByCode'])
    ->middleware('auth:admin');

    Route::get('/kiotvietbranch/getrawbyid'.'/{id}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch\KiotvietBranchController::class, 'getBranchById'])
    ->middleware('auth:admin');