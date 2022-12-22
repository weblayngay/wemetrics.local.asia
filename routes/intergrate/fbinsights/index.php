<?php

    /*
    |-------------------------------------------------------
    | FACEBOOK INSIGHTS
    |-------------------------------------------------------
    */
    /**facebook insights */
    Route::post('/fbinsights/store', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'store'])->middleware('auth:admin');
    Route::post('/fbinsights/update', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'update'])->middleware('auth:admin');
    Route::post('/fbinsights/copy', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'copy'])->middleware('auth:admin');
    Route::post('/fbinsights/duplicate', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/fbinsights/active', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'active'])->middleware('auth:admin');
    Route::post('/fbinsights/inactive', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/fbinsights/delete', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'delete'])->middleware('auth:admin');
    Route::post('/fbinsights/search', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'search'])->middleware('auth:admin');
    Route::get('/fbinsights/index', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'index'])->middleware('auth:admin');
    Route::get('/fbinsights/cpanel', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/fbinsights/create', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'create'])->middleware('auth:admin');
    Route::get('/fbinsights/edit', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'edit'])->middleware('auth:admin');
    Route::get('/fbinsights/reportOverview', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'reportOverview'])->middleware('auth:admin');
    Route::get('/fbinsights/reportPost', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'reportPost'])->middleware('auth:admin');
    Route::get('/fbinsights/reportLikes', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'reportLikes'])->middleware('auth:admin');
    Route::get('/fbinsights/report', [\App\Http\Controllers\Backend\Intergrate\FBInsights\FbinsightsController::class, 'report'])->middleware('auth:admin');