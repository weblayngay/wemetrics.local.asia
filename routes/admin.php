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




