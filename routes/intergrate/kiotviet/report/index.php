<?php
	
    /*
    |-------------------------------------------------------
    | INTERGRATE KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotvietinvoicereportoverview */
    Route::get('/kiotvietinvoicereportoverview/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietInvoiceReportOverviewController::class, 'preloadindex'])
    ->middleware('auth:admin');

    Route::get('/kiotvietinvoicereportoverview/index', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietInvoiceReportOverviewController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietinvoicereportoverview/preloadstats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietInvoiceReportOverviewController::class, 'preloadstats'])
    ->middleware('auth:admin');
    
    Route::post('/kiotvietinvoicereportoverview/stats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietInvoiceReportOverviewController::class, 'stats'])
    ->middleware('auth:admin');

    /**kiotvietcustomerreportoverview */
    Route::get('/kiotvietcustomerreportoverview/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCustomerReportOverviewController::class, 'preloadindex'])
    ->middleware('auth:admin');

    Route::get('/kiotvietcustomerreportoverview/index', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCustomerReportOverviewController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietcustomerreportoverview/preloadstats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCustomerReportOverviewController::class, 'preloadstats'])
    ->middleware('auth:admin');

    Route::post('/kiotvietcustomerreportoverview/stats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCustomerReportOverviewController::class, 'stats'])
    ->middleware('auth:admin');

    /**kiotvietcateproductreportoverview */
    Route::get('/kiotvietcateproductreportoverview/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'preloadindex'])
    ->middleware('auth:admin');

    Route::get('/kiotvietcateproductreportoverview/index', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietcateproductreportoverview/preloadstats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'preloadstats'])
    ->middleware('auth:admin');   

    Route::post('/kiotvietcateproductreportoverview/stats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'stats'])
    ->middleware('auth:admin');

    /** Begin Phân tích bán hàng 1 cửa hàng 1 nhóm hàng **/
    Route::get('/kiotvietcateproductreportoverview/preloaddrilldownbranchandcateproduct', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'preloaddrilldownbranchandcateproduct'])
    ->middleware('auth:admin');

    Route::get('/kiotvietcateproductreportoverview/drilldownbranchandcateproduct', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'drilldownbranchandcateproduct'])
    ->middleware('auth:admin');
    /** End Phân tích bán hàng 1 cửa hàng 1 nhóm hàng **/

    /** Begin Phân tích bán hàng nhiều cửa hàng 1 nhóm hàng **/
    Route::get('/kiotvietcateproductreportoverview/preloaddrilldownbranchesandcateproduct', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'preloaddrilldownbranchesandcateproduct'])
    ->middleware('auth:admin');

    Route::get('/kiotvietcateproductreportoverview/drilldownbranchesandcateproduct', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'drilldownbranchesandcateproduct'])
    ->middleware('auth:admin'); 
    /** End Phân tích bán hàng nhiều cửa hàng 1 nhóm hàng **/

    /** Begin Phân tích sản phẩm nhiều cửa hàng 1 nhóm hàng **/
    Route::get('/kiotvietcateproductreportoverview/preloaddrilldownbrachesandproducts', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'preloaddrilldownbrachesandproducts'])
    ->middleware('auth:admin');     

    Route::get('/kiotvietcateproductreportoverview/drilldownbrachesandproducts', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietCateProductReportOverviewController::class, 'drilldownbrachesandproducts'])
    ->middleware('auth:admin');  
    /** End Phân tích sản phẩm nhiều cửa hàng 1 nhóm hàng **/   

    /**kiotvietproductreportoverview */
    Route::get('/kiotvietproductreportoverview/preloadindex', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietProductReportOverviewController::class, 'preloadindex'])
    ->middleware('auth:admin');
    
    Route::get('/kiotvietproductreportoverview/index', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietProductReportOverviewController::class, 'index'])
    ->middleware('auth:admin');

    Route::post('/kiotvietproductreportoverview/preloadstats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietProductReportOverviewController::class, 'preloadstats'])
    ->middleware('auth:admin');  

    Route::post('/kiotvietproductreportoverview/stats', 
        [\App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\KiotvietProductReportOverviewController::class, 'stats'])
    ->middleware('auth:admin');    