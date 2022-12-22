<?php
/**
 * Created by PhpStorm.
 * User: cuong
 * Date: 10/9/2019
 * Time: 3:41 PM
 */
namespace App\Http\Controllers\Backend;

use App\Helpers\UrlHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class SystemController extends BaseController {

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function configCache(Request $request){
        Artisan::call('config:cache');
        $request->session()->put(SESSION_SUCCESS_KEY, 'Cache hệ thống thành công');
        return redirect()->route(ADMIN_ROUTE . '.dashboard');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function configClear(Request $request){
        Artisan::call('config:clear');
        $request->session()->put(SESSION_SUCCESS_KEY, 'Xóa Cache hệ thống thành công');
        return redirect()->route(ADMIN_ROUTE . '.dashboard');
    }


    /**
     * @return string
     */
    public function phpInfo(){
        echo phpinfo();
        return '';
    }

}
