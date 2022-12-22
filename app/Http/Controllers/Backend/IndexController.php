<?php
namespace App\Http\Controllers\Backend;

use App\Models\AdminMenu;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends BaseController
{
    private AdminMenu $adminMenuModel;

    public function __construct()
    {
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['parentMenus'] = $this->adminMenuModel::parentQuery()->isParent()->isActivated()->get();
        return view($this->viewPath . 'index.index', compact('data'));
    }
}
