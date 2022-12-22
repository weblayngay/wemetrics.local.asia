<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\UrlHelper;
use App\Http\Requests\AdminGroupRequest;
use App\Models\AdminGroup;
use App\Models\AdminMenu;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdmingroupController extends BaseController
{
    /**
     * @var AdminGroup
     */
    private AdminGroup $adminGroupModel;
    private AdminMenu $adminMenuModel;

    private $view = '.admingroup';

    /**
     * AdmingroupController constructor.
     */
    public function __construct()
    {
        $this->adminGroupModel = new AdminGroup();
        $this->adminMenuModel  = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['adminGroups'] = $this->adminGroupModel::query()->get();
        $data['title'] = 'Quản lý nhóm thành viên';
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
        $this->adminGroupModel::query()->whereIn('adgroup_id', $ids)->update(['status' => 'activated']);
        return back()->with('success', 'Bật nhóm thành viên thành công');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function inactive(Request $request): RedirectResponse
    {
        $ids = $request->post('cid', []);
        $this->adminGroupModel::query()->whereIn('adgroup_id', $ids)->update(['status' => 'inactive']);
        return back()->with('success', 'Tắt nhóm thành viên thành công');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $ids = $request->post('cid', []);
        $this->adminGroupModel::query()->whereIn('adgroup_id', $ids)->delete();
        return back()->with('success', 'Xóa thành công');
    }


    /**
     * @return Application|Factory|View
     */
    public function detail()
    {
        $id = \request()->get('id', null);

        $data['title'] = 'Phân quyền cho nhóm: [Thêm]';
        if ($id != null) {
            $data['title'] = 'Phân quyền cho nhóm: [Sửa]';
            $adminGroup = $this->adminGroupModel::query()->find($id);
            $data['adminGroup'] = $adminGroup;
            if (!$adminGroup){
                return redirect()
                    ->to(UrlHelper::admin('admingroup', 'index'))
                    ->with('error', 'Nhóm thành viên không tìm thấy');
            }
        }

        $data['adminMenus'] = $this->adminMenuModel::query()->orderBy('admenu_id', 'asc')->orderBy('parent', 'desc')->get();

        return view($this->viewPath . $this->view . '.detail' , compact('data'));
    }

    /**
     * @param AdminGroupRequest $request
     * @return RedirectResponse
     */
    public function save(AdminGroupRequest $request)
    {
        $id     = $request->post('id', null);
        $status = $request->post('status');
        $name   = $request->post('name', '');
        $description = $request->post('description', '');
        $menu   = $request->post('menu', []);
        $data = [
            'name'          => strip_tags($name),
            'status'        => ($status == 'activated') ? 'activated' : 'inactive',
            'description'   => strip_tags($description),
            'admenu_ids'    => $this->adminGroupModel->getIds($menu)
        ];

        $message = 'Tạo mới nhóm thành viên thành công.';
        if ($id > 0){ // Update
            $message = 'Cập nhật nhóm thành viên thành công.';
            $adminGroup = $this->adminGroupModel::query()->find($id);
            if (!$adminGroup) {
                return redirect()
                    ->to(UrlHelper::admin('admingroup', 'index'))
                    ->with('error', 'Nhóm thành viên không tìm thấy') ;
            } else {
                $adminGroup->update($data);
            }
        }else{ // Create new
            $newAdminGroup = $this->adminGroupModel::parentQuery()->create($data);
            $id = $newAdminGroup->adgroup_id;
        }


        if ($request->post('action_type') == 'save') {
            return redirect()->to(UrlHelper::admin('admingroup', 'index'))->with('success', $message);
        } else {
            return redirect()->to(UrlHelper::admin('admingroup', 'detail', ['id' => $id]))->with('success', $message) ;
        }
    }

}
