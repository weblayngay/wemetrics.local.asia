<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\StringHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class KiotvietController extends BaseController
{
    private $view = '.kiotviet';
    private $model = 'kiotviet';
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function cpanel()
    {
        $data['title'] = KIOTVIET_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('kiotviet');
        return view($data['view'] , compact('data'));
    }
}