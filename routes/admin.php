<?php

use App\Http\Controllers\Backend\Auth\LoginController;
use Illuminate\Support\Facades\Route;

if (!defined('ADMIN_ROUTE')) {
    define('ADMIN_ROUTE', 'admins');
}

require_once('routes/const/routes.php');

Route::group(['prefix' => ADMIN_ROUTE], function () {
    Route::get('/caching.system', [\App\Http\Controllers\Backend\SystemController::class, 'configCache']);

    /*
    |-------------------------------------------------------
    | LOGIN
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_LOGIN);

    /*
    |-------------------------------------------------------
    | DASHBOARD
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_DASHBOARD);

    /*
    |-------------------------------------------------------
    | PRODUCT
    |-------------------------------------------------------
    /**product*/
    require_once('routes/'.ROUTE_PRODUCT);

    /*
    |-------------------------------------------------------
    | COLOR
    |-------------------------------------------------------
    /**color*/
    require_once('routes/'.ROUTE_PRODUCT_COLOR);

    /*
    |-------------------------------------------------------
    | SIZE
    |-------------------------------------------------------
    /**size*/
    require_once('routes/'.ROUTE_PRODUCT_SIZE);

    /*
    |-------------------------------------------------------
    | NUTRITIONS
    |-------------------------------------------------------
    /**nutritions*/
    require_once('routes/'.ROUTE_PRODUCT_NUTRITIONS);

    /*
    |-------------------------------------------------------
    | ODOROUS
    |-------------------------------------------------------
    /**odorous*/
    require_once('routes/'.ROUTE_PRODUCT_ODOROUS);

    /*
    |-------------------------------------------------------
    | COLLECTION
    |-------------------------------------------------------
    /**collection*/
    require_once('routes/'.ROUTE_PRODUCT_COLLECTION);

    /*
    |-------------------------------------------------------
    | PRODUCER
    |-------------------------------------------------------
    /**producer*/
    require_once('routes/'.ROUTE_PRODUCT_PRODUCER);

    /*
    |-------------------------------------------------------
    | POST
    |-------------------------------------------------------
    /**post*/
    require_once('routes/'.ROUTE_POST);

    /*
    |-------------------------------------------------------
    | ADVERT
    |-------------------------------------------------------
    /**advert*/
    require_once('routes/'.ROUTE_ADVERT);

    /*
    |-------------------------------------------------------
    | BANNER
    |-------------------------------------------------------
    /**banner*/
    require_once('routes/'.ROUTE_BANNER);

    /*
    |-------------------------------------------------------
    | MENU
    |-------------------------------------------------------
    /**menu*/
    require_once('routes/'.ROUTE_MENU);

    /*
    |-------------------------------------------------------
    | ADMIN GROUP
    |-------------------------------------------------------
    /**admingroup*/
    require_once('routes/'.ROUTE_ADMINGROUP);

    /*
    |-------------------------------------------------------
    | CONTACT
    |-------------------------------------------------------
    /**contact*/
    require_once('routes/'.ROUTE_CONTACT);    

    /*
    |-------------------------------------------------------
    | ORDER
    |-------------------------------------------------------
    /**order*/
    require_once('routes/'.ROUTE_ORDER);

    /*
    |-------------------------------------------------------
    | AFFILIATE REPORT
    |-------------------------------------------------------
    /**affiliate */
    require_once('routes/'.ROUTE_AFFILIATE);

    /*
    |-------------------------------------------------------
    | COMMENT
    |-------------------------------------------------------
    /**comment */
    require_once('routes/'.ROUTE_COMMENT);

    /*
    |-------------------------------------------------------
    | USER
    |-------------------------------------------------------
    */
    /** user */
    require_once('routes/'.ROUTE_USER);

    /*
    |-------------------------------------------------------
    | VOUCHER
    |-------------------------------------------------------
    */
    /**voucher */
    require_once('routes/'.ROUTE_VOUCHER);

    /*
    |-------------------------------------------------------
    | CAMPAIGN
    |-------------------------------------------------------
    */
    /**campaign */
    require_once('routes/'.ROUTE_CAMPAIGN);
    
    /*
    |-------------------------------------------------------
    | PERCEIVED VALUE
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_PRODUCT_PERCEIVED);

    /*
    |-------------------------------------------------------
    | GOOGLE ANALYTICS
    |-------------------------------------------------------
    */
    /**google analytics */
    require_once('routes/'.ROUTE_INTERGRATE_GGANALYTICS);

    /*
    |-------------------------------------------------------
    | GOOGLE ADWORDS
    |-------------------------------------------------------
    */
    /**google adwords */
    require_once('routes/'.ROUTE_INTERGRATE_GGADS);

    /*
    |-------------------------------------------------------
    | FACEBOOK ADS
    |-------------------------------------------------------
    */
    /**facebook ads */
    require_once('routes/'.ROUTE_INTERGRATE_FBADS);

    /*
    |-------------------------------------------------------
    | FACEBOOK INSIGHTS
    |-------------------------------------------------------
    */
    /**facebook insights */
    require_once('routes/'.ROUTE_INTERGRATE_FBINSIGHTS);

    /*
    |-------------------------------------------------------
    | TIKTOK ADS
    |-------------------------------------------------------
    */
    /**tiktok ads */
    require_once('routes/'.ROUTE_INTERGRATE_TIKTOKADS);

    /*
    |-------------------------------------------------------
    | CTOKEN IN
    |-------------------------------------------------------
    */
    /**ctoken in */
    require_once('routes/'.ROUTE_CTOKENIN);

    /*
    |-------------------------------------------------------
    | CTOKEN OUT
    |-------------------------------------------------------
    */
    /**ctoken out */
    require_once('routes/'.ROUTE_CTOKENOUT);

    /*
    |-------------------------------------------------------
    | CTOKEN VENDOR
    |-------------------------------------------------------
    */
    /**ctoken vendor */
    require_once('routes/'.ROUTE_CTOKENVENDOR);

    /*
    |-------------------------------------------------------
    | CLIENTTRACKING
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_CLIENTTRACKING);

    /*
    |-------------------------------------------------------
    | KIOTVIET
    |-------------------------------------------------------
    */
    /**kiotviet */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET);

    /**kiotvietproduct */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_PRODUCT);

    /**kiotvietinvoice */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_INVOICE);

    /**kiotvietpurchaseorder */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_PURCHASE_ORDER);

    /**kiotvietproductonhand */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_PRODUCT_ONHAND);

    /**kiotvietbranch */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_BRANCH);

    /**kiotvietcustomer */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_CUSTOMER);

    /**kiotvietreport */
    require_once('routes/'.ROUTE_INTERGRATE_KIOTVIET_REPORT);

    /*
    |-------------------------------------------------------
    | ANALYTICS TOOLKIT
    |-------------------------------------------------------
    */
    /**analytics toolkit */
    require_once('routes/'.ROUTE_INTERGRATE_ANALYTICSTOOLKIT);


    /*
    |-------------------------------------------------------
    | SYSTEM
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_SYSTEM);

    /*
    |-------------------------------------------------------
    | CONFIG
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_CONFIG);


    /*
    |-------------------------------------------------------
    | ADMIN MENU
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_ADMINMENU);

    /*
    |-------------------------------------------------------
    | ADMIN USER
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_ADMINUSER);

    /*
    |-------------------------------------------------------
    | PRODUCT CATEGORY
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_PRODUCT_CATEGORY);

    /*
    |-------------------------------------------------------
    | BLOCK
    |-------------------------------------------------------
    */
    require_once('routes/'.ROUTE_BLOCK);


    $namespace = 'App\Http\Controllers\Backend\\';
    Route::get('/{controller?}/{action?}', function ($controller = 'index', $action = 'index') use ($namespace) {
        $controllerName = ucfirst($controller);
        $class          = $namespace . $controllerName.'Controller';
        $controller     = new $class();
        return $controller->{$action}();
    })->where(['controller' => '[a-z0-9]+', 'action' => '[a-z0-9]+'])->name(ADMIN_ROUTE)->middleware('auth:admin');
});




