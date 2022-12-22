<?php

    /*
    |-------------------------------------------------------
    | FACEBOOK ADS
    |-------------------------------------------------------
    */
    /**facebook ads */
    Route::post('/fbads/store', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'store'])->middleware('auth:admin');
    Route::post('/fbads/update', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'update'])->middleware('auth:admin');
    Route::post('/fbads/copy', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'copy'])->middleware('auth:admin');
    Route::post('/fbads/duplicate', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/fbads/active', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'active'])->middleware('auth:admin');
    Route::post('/fbads/inactive', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/fbads/delete', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'delete'])->middleware('auth:admin');
    Route::post('/fbads/search', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'search'])->middleware('auth:admin');
    Route::get('/fbads/index', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'index'])->middleware('auth:admin');
    Route::get('/fbads/cpanel', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/fbads/create', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'create'])->middleware('auth:admin');
    Route::get('/fbads/edit', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'edit'])->middleware('auth:admin');
    Route::get('/fbads/reportOverview', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportOverview'])->middleware('auth:admin');
    Route::get('/fbads/reportAuction', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportAuction'])->middleware('auth:admin');
    Route::get('/fbads/reportPerformance', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportPerformance'])->middleware('auth:admin');
    Route::get('/fbads/reportCampaign', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportCampaign'])->middleware('auth:admin');
    Route::get('/fbads/reportDevice', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportDevice'])->middleware('auth:admin');
    Route::get('/fbads/reportDemographic', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportDemographic'])->middleware('auth:admin');
    Route::get('/fbads/reportCompare', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'reportCompare'])->middleware('auth:admin');
    Route::get('/fbads/report', [\App\Http\Controllers\Backend\Intergrate\FBAds\FbadsController::class, 'report'])->middleware('auth:admin');