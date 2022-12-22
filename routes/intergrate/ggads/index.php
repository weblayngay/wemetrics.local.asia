<?php

    /*
    |-------------------------------------------------------
    | GOOGLE ADWORDS
    |-------------------------------------------------------
    */
    /**google adwords */
    Route::post('/ggadwords/store', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'store'])->middleware('auth:admin');
    Route::post('/ggadwords/update', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'update'])->middleware('auth:admin');
    Route::post('/ggadwords/copy', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'copy'])->middleware('auth:admin');
    Route::post('/ggadwords/duplicate', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/ggadwords/active', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'active'])->middleware('auth:admin');
    Route::post('/ggadwords/inactive', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/ggadwords/delete', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'delete'])->middleware('auth:admin');
    Route::post('/ggadwords/search', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'search'])->middleware('auth:admin');
    Route::get('/ggadwords/index', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'index'])->middleware('auth:admin');
    Route::get('/ggadwords/cpanel', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/ggadwords/create', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'create'])->middleware('auth:admin');
    Route::get('/ggadwords/edit', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'edit'])->middleware('auth:admin');
    Route::get('/ggadwords/reportOverview', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportOverview'])->middleware('auth:admin');
    Route::get('/ggadwords/reportAuction', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportAuction'])->middleware('auth:admin');
    Route::get('/ggadwords/reportPerformance', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportPerformance'])->middleware('auth:admin');
    Route::get('/ggadwords/reportCampaign', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportCampaign'])->middleware('auth:admin');
    Route::get('/ggadwords/reportDevice', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportDevice'])->middleware('auth:admin');
    Route::get('/ggadwords/reportDemographic', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportDemographic'])->middleware('auth:admin');
    Route::get('/ggadwords/reportCompare', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'reportCompare'])->middleware('auth:admin');
    Route::get('/ggadwords/report', [\App\Http\Controllers\Backend\Intergrate\GGAdwords\GgadwordsController::class, 'report'])->middleware('auth:admin');