<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietproduct */
    Route::get('/kiotvietProduct/getraw', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'getRawProduct'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/getrawfirst', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'getRawProductFirst'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/getrawbyname'.'/{searchStr}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'getRawProductByName'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/getrawbyid'.'/{id}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'getProductById'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/getrawbycode'.'/{code}', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'getProductByCode'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'preloadindex'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/index',
         [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietProduct/preloadsearch', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'preloadsearch'])
    ->middleware('auth:admin');

    Route::post('/kiotvietProduct/search', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'search'])
    ->middleware('auth:admin');
    //
    Route::get('/kiotvietProduct/paginate', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'search'])
    ->middleware('auth:admin');

    Route::get('/kiotvietProduct/edit', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Product\KiotvietProductController::class, 'edit'])
    ->middleware('auth:admin');