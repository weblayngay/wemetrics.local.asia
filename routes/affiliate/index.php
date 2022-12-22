<?php
	
    /*
    |-------------------------------------------------------
    | AFFILIATE REPORT
    |-------------------------------------------------------
    */
    /**affiliate*/
    Route::get('/affiliate/cpanel', [\App\Http\Controllers\Backend\Affiliate\AffiliateController::class, 'cpanel'])->middleware('auth:admin');

    /**affiliatesalesreportoverview */
    Route::get('/affiliatesalesreportoverview/index', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliateSalesReportOverviewController::class, 'index'])->middleware('auth:admin');
    Route::post('/affiliatesalesreportoverview/stats', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliateSalesReportOverviewController::class, 'stats'])->middleware('auth:admin');

    /**affiliatecommreportoverview */
    Route::get('/affiliatecommreportoverview/index', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliateCommReportOverviewController::class, 'index'])->middleware('auth:admin');
    Route::post('/affiliatecommreportoverview/stats', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliateCommReportOverviewController::class, 'stats'])->middleware('auth:admin');

    /**affiliatepaycommreportoverview */
    Route::get('/affiliatepaycommreportoverview/index', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliatePayCommReportOverviewController::class, 'index'])->middleware('auth:admin');
    Route::post('/affiliatepaycommreportoverview/stats', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliatePayCommReportOverviewController::class, 'stats'])->middleware('auth:admin');

    /**affiliateproductreportoverview */
    Route::get('/affiliateproductreportoverview/index', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliateProductReportOverviewController::class, 'index'])->middleware('auth:admin');
    Route::post('/affiliateproductreportoverview/stats', [\App\Http\Controllers\Backend\Affiliate\Report\AffiliateProductReportOverviewController::class, 'stats'])->middleware('auth:admin');



