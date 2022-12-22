<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\FileHelper;
use App\Helpers\UrlHelper;
use App\Http\Requests\AdminMenuRequest;
use App\Models\AdminMenu;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminmenuController extends BaseController
{

    /**
     * @var AdminMenu
     */
    private AdminMenu $adminMenuModel;

    /**
     * @var string
     */
    private $view = 'adminmenu';

    public function __construct(AdminMenu $adminMenuModel)
    {
        $this->adminMenuModel = $adminMenuModel;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['adminMenus'] = $this->adminMenuModel::parentQuery()->get();
        $data['title'] = 'Quản lý Menu của trang Admin';
        $data['view']  = $this->viewPath . $this->view . '.index';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function active(Request $request): RedirectResponse
    {
        $ids = $request->post('cid', []);
        $this->adminMenuModel::parentQuery()->whereIn('admenu_id', $ids)->update(['status' => 'activated']);
        return back()->with('success', 'Bật nhóm thành viên thành công');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function inactive(Request $request): RedirectResponse
    {
        $ids = $request->post('cid', []);
        $this->adminMenuModel::parentQuery()->whereIn('admenu_id', $ids)->update(['status' => 'inactive']);
        return back()->with('success', 'Tắt nhóm thành viên thành công');
    }

    /**
     * @return Application|Factory|View
     */
    public function detail()
    {
        $id = \request()->get('id', null);

        $data['title'] = 'Menu trang admin: [Thêm]';
        if ($id != null) {
            $data['title'] = 'Menu trang admin: [Sửa]';
            $adminMenu = $this->adminMenuModel::parentQuery()->find($id);
            $data['adminMenu'] = $adminMenu;
            if (!$adminMenu){
                return redirect()
                    ->to(UrlHelper::admin('adminmenu', 'index'))
                    ->with('error', 'Menu trang admin không tìm thấy');
            }
        }

        // get all icons file
        $data['icons'] = FileHelper::getIconOfAdmin(['png']);

        /**
         * Admin menu parent
         */
        $data['parentMenus'] = $this->adminMenuModel->getMenusByType('parent');

        return view($this->viewPath . $this->view . '.detail' , compact('data'));
    }


    /**
     * @param AdminMenuRequest $request
     * @return RedirectResponse
     */
    public function save(AdminMenuRequest $request)
    {
        $id         = $request->post('id', 0);
        $name       = $request->post('name');
        $controller = $request->post('controller', '');
        $action     = $request->post('action', '');
        $parent     = $request->post('parent', 0);
        $status     = $request->post('status', 'inactive');
        $icon       = $request->post('icon', '');
        $data = [
            'name'          => strip_tags($name),
            'controller'    => strip_tags(trim($controller)),
            'action'        => strip_tags(trim($action)),
            'parent'        => $parent,
            'status'        => $status,
            'icon'          => strip_tags($icon),
        ];

        $message = 'Tạo mới menu trang Admin thành công.';
        if ($id > 0){ // Update
            $message    = 'Cập nhật menu trang Admin thành công.';
            $adminMenu  = $this->adminMenuModel::parentQuery()->find($id);
            if (!$adminMenu) {
                return redirect()
                    ->to(UrlHelper::admin('adminmenu', 'index'))
                    ->with('error', 'Menu trang admin không tìm thấy') ;
            } else {
                $adminMenu->update($data);
            }
        }else{ // Create new
            $newAdminMenu= $this->adminMenuModel::parentQuery()->create($data);
            $id = $newAdminMenu->admenu_id;
        }


        if ($request->post('action_type') == 'save') {
            return redirect()->to(UrlHelper::admin('adminmenu', 'index'))->with('success', $message);
        } else {
            return redirect()->to(UrlHelper::admin('adminmenu', 'detail', ['id' => $id]))->with('success', $message) ;
        }
    }

}
