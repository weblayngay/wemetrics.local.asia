<?php
	
    /*
    |-------------------------------------------------------
    | CAMPAIGN
    |-------------------------------------------------------
    */
    /**campaign */
    Route::post('/campaign/store', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'store'])->middleware('auth:admin');
    Route::post('/campaign/update', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'update'])->middleware('auth:admin');
    Route::post('/campaign/copy', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'copy'])->middleware('auth:admin');
    Route::post('/campaign/duplicate', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/campaign/active', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'active'])->middleware('auth:admin');
    Route::post('/campaign/inactive', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/campaign/delete', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'delete'])->middleware('auth:admin');
    Route::post('/campaign/search', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'search'])->middleware('auth:admin');
    Route::get('/campaign/index', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'index'])->middleware('auth:admin');
    Route::get('/campaign/create', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'create'])->middleware('auth:admin');
    Route::get('/campaign/edit', [\App\Http\Controllers\Backend\Campaign\CampaignController::class, 'edit'])->middleware('auth:admin');

    /**campaigntype */
    Route::post('/campaigntype/store', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'store'])->middleware('auth:admin');
    Route::post('/campaigntype/update', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'update'])->middleware('auth:admin');
    Route::post('/campaigntype/copy', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'copy'])->middleware('auth:admin');
    Route::post('/campaigntype/duplicate', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/campaigntype/active', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'active'])->middleware('auth:admin');
    Route::post('/campaigntype/inactive', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/campaigntype/delete', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'delete'])->middleware('auth:admin');
    Route::post('/campaigntype/search', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'search'])->middleware('auth:admin');
    Route::get('/campaigntype/index', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'index'])->middleware('auth:admin');
    Route::get('/campaigntype/create', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'create'])->middleware('auth:admin');
    Route::get('/campaigntype/edit', [\App\Http\Controllers\Backend\Campaign\CampaignTypeController::class, 'edit'])->middleware('auth:admin');

    /**campaign group */
    Route::post('/campaigngroup/store', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'store'])->middleware('auth:admin');
    Route::post('/campaigngroup/update', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'update'])->middleware('auth:admin');
    Route::post('/campaigngroup/copy', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'copy'])->middleware('auth:admin');
    Route::post('/campaigngroup/duplicate', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/campaigngroup/active', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'active'])->middleware('auth:admin');
    Route::post('/campaigngroup/inactive', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/campaigngroup/delete', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'delete'])->middleware('auth:admin');
    Route::post('/campaigngroup/search', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'search'])->middleware('auth:admin');
    Route::get('/campaigngroup/index', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'index'])->middleware('auth:admin');
    Route::get('/campaigngroup/create', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'create'])->middleware('auth:admin');
    Route::get('/campaigngroup/edit', [\App\Http\Controllers\Backend\Campaign\CampaigngroupController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CAMPAIGN RESULT
    |-------------------------------------------------------
    */
    /**campaignresult */
    Route::post('/campaignresult/search', [\App\Http\Controllers\Backend\Campaign\CampaignResultController::class, 'search'])->middleware('auth:admin');
    Route::get('/campaignresult/index', [\App\Http\Controllers\Backend\Campaign\CampaignResultController::class, 'index'])->middleware('auth:admin');
    Route::get('/campaignresult/show', [\App\Http\Controllers\Backend\Campaign\CampaignResultController::class, 'show'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CAMPAIGN STATISTIC
    |-------------------------------------------------------
    */
    /**campaignstatistic */
    Route::get('/campaignstatistic/index', [\App\Http\Controllers\Backend\Campaign\CampaignStatisticController::class, 'index'])->middleware('auth:admin');
    Route::post('/campaignstatistic/stats', [\App\Http\Controllers\Backend\Campaign\CampaignStatisticController::class, 'stats'])->middleware('auth:admin');



