<?php
    /*
    |-------------------------------------------------------
    | CLIENT TRACKING
    |-------------------------------------------------------
    */
    /**client tracking */
    Route::get('/clienttracking/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingController::class, 'cpanel'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | UTM SOURCE
    |-------------------------------------------------------
    */
    /**utm source */
    Route::post('/utmsource/store', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'store'])->middleware('auth:admin');
    Route::post('/utmsource/update', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'update'])->middleware('auth:admin');
    Route::post('/utmsource/copy', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'copy'])->middleware('auth:admin');
    Route::post('/utmsource/duplicate', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/utmsource/active', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'active'])->middleware('auth:admin');
    Route::post('/utmsource/inactive', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/utmsource/delete', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'delete'])->middleware('auth:admin');
    Route::post('/utmsource/search', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'search'])->middleware('auth:admin');
    Route::get('/utmsource/index', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'index'])->middleware('auth:admin');
    Route::get('/utmsource/cpanel', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/utmsource/create', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'create'])->middleware('auth:admin');
    Route::get('/utmsource/edit', [\App\Http\Controllers\Backend\ClientTracking\UtmsourceController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | UTM MEDIUM
    |-------------------------------------------------------
    */
    /**utm medium */
    Route::post('/utmmedium/store', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'store'])->middleware('auth:admin');
    Route::post('/utmmedium/update', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'update'])->middleware('auth:admin');
    Route::post('/utmmedium/copy', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'copy'])->middleware('auth:admin');
    Route::post('/utmmedium/duplicate', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/utmmedium/active', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'active'])->middleware('auth:admin');
    Route::post('/utmmedium/inactive', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/utmmedium/delete', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'delete'])->middleware('auth:admin');
    Route::post('/utmmedium/search', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'search'])->middleware('auth:admin');
    Route::get('/utmmedium/index', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'index'])->middleware('auth:admin');
    Route::get('/utmmedium/cpanel', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/utmmedium/create', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'create'])->middleware('auth:admin');
    Route::get('/utmmedium/edit', [\App\Http\Controllers\Backend\ClientTracking\UtmmediumController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | UTM CAMPAIGN
    |-------------------------------------------------------
    */
    /**utm campaign */
    Route::post('/utmcampaign/store', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'store'])->middleware('auth:admin');
    Route::post('/utmcampaign/update', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'update'])->middleware('auth:admin');
    Route::post('/utmcampaign/copy', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'copy'])->middleware('auth:admin');
    Route::post('/utmcampaign/duplicate', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/utmcampaign/active', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'active'])->middleware('auth:admin');
    Route::post('/utmcampaign/inactive', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/utmcampaign/delete', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'delete'])->middleware('auth:admin');
    Route::post('/utmcampaign/search', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'search'])->middleware('auth:admin');
    Route::get('/utmcampaign/index', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'index'])->middleware('auth:admin');
    Route::get('/utmcampaign/cpanel', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/utmcampaign/create', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'create'])->middleware('auth:admin');
    Route::get('/utmcampaign/edit', [\App\Http\Controllers\Backend\ClientTracking\UtmcampaignController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | UTM CREATOR
    |-------------------------------------------------------
    */
    /**utm creator */
    Route::get('/utmcreator/index', [\App\Http\Controllers\Backend\ClientTracking\UtmcreatorController::class, 'index'])->middleware('auth:admin');
    
	/*
    |-------------------------------------------------------
    | CLIENT TRACKING BROWSER
    |-------------------------------------------------------
    */
    /**client tracking browser */
    Route::post('/clienttrackingbrowser/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingbrowser/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingbrowser/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingbrowser/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingbrowser/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingbrowser/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingbrowserController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING DEVICE
    |-------------------------------------------------------
    */
    /**client tracking device */
    Route::post('/clienttrackingdevice/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingdevice/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingdevice/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingdevice/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingdevice/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingdevice/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingdeviceController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING PLATFORM
    |-------------------------------------------------------
    */
    /**client tracking platform */
    Route::post('/clienttrackingplatform/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingplatform/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingplatform/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingplatform/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingplatform/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingplatform/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingplatformController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REFERER
    |-------------------------------------------------------
    */
    /**client tracking referer */
    Route::post('/clienttrackingreferer/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingreferer/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingreferer/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingreferer/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingreferer/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingreferer/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingrefererController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REGION
    |-------------------------------------------------------
    */
    /**client tracking region */
    Route::post('/clienttrackingregion/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingregion/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingregion/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingregion/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingregion/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingregion/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingregionController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING BLOCKIP
    |-------------------------------------------------------
    */
    /**client tracking blockip */
    Route::post('/clienttrackingblockip/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingblockip/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingblockip/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingblockip/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingblockip/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingblockip/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingblockipController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING WHITELISTIP
    |-------------------------------------------------------
    */
    /**client tracking whitelistip */
    Route::post('/clienttrackingwhitelistip/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingwhitelistip/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingwhitelistip/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingwhitelistip/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingwhitelistip/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingwhitelistip/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingwhitelistipController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING EXLUDE REQUEST RUI
    |-------------------------------------------------------
    */
    /**client tracking excludereqrui */
    Route::post('/clienttrackingexcludereqrui/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingexcludereqrui/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingexcludereqrui/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingexcludereqrui/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingexcludereqrui/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingexcludereqrui/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingexcludereqruiController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING ILLEGAL REQUEST RUI
    |-------------------------------------------------------
    */
    /**client tracking illegalreqrui */
    Route::post('/clienttrackingillegalreqrui/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingillegalreqrui/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingillegalreqrui/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingillegalreqrui/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingillegalreqrui/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingillegalreqrui/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingillegalreqruiController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPLACE REQUEST RUI
    |-------------------------------------------------------
    */
    /**client tracking replacereqrui */
    Route::post('/clienttrackingreplacereqrui/store', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'store'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/update', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'update'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/copy', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'copy'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/duplicate', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'duplicate'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/active', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'active'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/inactive', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'inactive'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/delete', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'delete'])->middleware('auth:admin');
    Route::post('/clienttrackingreplacereqrui/search', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'search'])->middleware('auth:admin');
    Route::get('/clienttrackingreplacereqrui/index', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'index'])->middleware('auth:admin');
    Route::get('/clienttrackingreplacereqrui/cpanel', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'cpanel'])->middleware('auth:admin');
    Route::get('/clienttrackingreplacereqrui/create', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'create'])->middleware('auth:admin');
    Route::get('/clienttrackingreplacereqrui/edit', [\App\Http\Controllers\Backend\ClientTracking\ClienttrackingreplacereqruiController::class, 'edit'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT OVERVIEW
    |-------------------------------------------------------
    */
    /**client tracking report overview */
    Route::get('/clienttrackingreportoverview/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportoverviewController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportoverview/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportoverviewController::class, 'stats'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT SOURCE
    |-------------------------------------------------------
    */
    /**client tracking report source */
    Route::get('/clienttrackingreportsource/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportsourceController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportsource/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportsourceController::class, 'stats'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT BROWSER
    |-------------------------------------------------------
    */
    /**client tracking report browser */
    Route::get('/clienttrackingreportbrowser/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportbrowserController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportbrowser/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportbrowserController::class, 'stats'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT DEVICE
    |-------------------------------------------------------
    */
    /**client tracking report device */
    Route::get('/clienttrackingreportdevice/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportdeviceController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportdevice/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportdeviceController::class, 'stats'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT PLATFORM
    |-------------------------------------------------------
    */
    /**client tracking report platform */
    Route::get('/clienttrackingreportplatform/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportplatformController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportplatform/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportplatformController::class, 'stats'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT GEO
    |-------------------------------------------------------
    */
    /**client tracking report geo */
    Route::get('/clienttrackingreportgeo/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportgeoController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportgeo/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportgeoController::class, 'stats'])->middleware('auth:admin');

    /*
    |-------------------------------------------------------
    | CLIENT TRACKING REPORT ADS
    |-------------------------------------------------------
    */
    /**client tracking report ads */
    Route::get('/clienttrackingreportads/index', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportadsController::class, 'index'])->middleware('auth:admin');
    Route::post('/clienttrackingreportads/stats', [\App\Http\Controllers\Backend\ClientTracking\Report\ClienttrackingreportadsController::class, 'stats'])->middleware('auth:admin');




