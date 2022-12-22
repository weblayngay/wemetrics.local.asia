<?php

    /*
    |-------------------------------------------------------
    | GOOGLE ANALYTICS
    |-------------------------------------------------------
    */
    /**google analytics */
    Route::post('/gganalytics/store', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'store'])->middleware('auth:admin');
    Route::post('/gganalytics/update', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'update'])->middleware('auth:admin');
    Route::post('/gganalytics/copy', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'copy'])->middleware('auth:admin');
    Route::post('/gganalytics/duplicate', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/gganalytics/active', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'active'])->middleware('auth:admin');
    Route::post('/gganalytics/inactive', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/gganalytics/delete', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'delete'])->middleware('auth:admin');
    Route::post('/gganalytics/search', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'search'])->middleware('auth:admin');
    Route::get('/gganalytics/index', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'index'])->middleware('auth:admin');
    Route::get('/gganalytics/cpanel', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/gganalytics/create', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'create'])->middleware('auth:admin');
    Route::get('/gganalytics/edit', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'edit'])->middleware('auth:admin');
    Route::get('/gganalytics/reportBehavior', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'reportBehavior'])->middleware('auth:admin');
    Route::get('/gganalytics/reportAudience', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'reportAudience'])->middleware('auth:admin');
    Route::get('/gganalytics/reportAcquisition', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'reportAcquisition'])->middleware('auth:admin');
    Route::get('/gganalytics/reportMerchant', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'reportMerchant'])->middleware('auth:admin');
    Route::get('/gganalytics/reportFunnel', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'reportFunnel'])->middleware('auth:admin');
    Route::get('/gganalytics/report', [\App\Http\Controllers\Backend\Intergrate\GGAnalytics\GganalyticsController::class, 'report'])->middleware('auth:admin');