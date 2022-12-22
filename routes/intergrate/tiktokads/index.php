<?php

	/*
    |-------------------------------------------------------
    | TIKTOK ADS
    |-------------------------------------------------------
    */
    /**tiktok ads */
    Route::post('/tiktokads/store', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'store'])->middleware('auth:admin');
    Route::post('/tiktokads/update', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'update'])->middleware('auth:admin');
    Route::post('/tiktokads/copy', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'copy'])->middleware('auth:admin');
    Route::post('/tiktokads/duplicate', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/tiktokads/active', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'active'])->middleware('auth:admin');
    Route::post('/tiktokads/inactive', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/tiktokads/delete', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'delete'])->middleware('auth:admin');
    Route::post('/tiktokads/search', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'search'])->middleware('auth:admin');
    Route::get('/tiktokads/index', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'index'])->middleware('auth:admin');
    Route::get('/tiktokads/cpanel', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/tiktokads/create', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'create'])->middleware('auth:admin');
    Route::get('/tiktokads/edit', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'edit'])->middleware('auth:admin');
    Route::get('/tiktokads/reportOverview', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportOverview'])->middleware('auth:admin');
    Route::get('/tiktokads/reportAuction', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportAuction'])->middleware('auth:admin');
    Route::get('/tiktokads/reportPerformance', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportPerformance'])->middleware('auth:admin');
    Route::get('/tiktokads/reportCampaign', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportCampaign'])->middleware('auth:admin');
    Route::get('/tiktokads/reportPlatform', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportPlatform'])->middleware('auth:admin');
    Route::get('/tiktokads/reportDemographic', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportDemographic'])->middleware('auth:admin');
    Route::get('/tiktokads/reportCompare', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'reportCompare'])->middleware('auth:admin');
    Route::get('/tiktokads/report', [\App\Http\Controllers\Backend\Intergrate\TikTokAds\TiktokadsController::class, 'report'])->middleware('auth:admin');