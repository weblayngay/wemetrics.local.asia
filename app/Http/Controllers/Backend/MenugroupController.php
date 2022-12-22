<?php

namespace App\Http\Controllers\Backend;

use App\Models\MenuGroup;
use App\Http\Requests\MenuGroupRequest;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenugroupController extends BaseController
{
    private $view = '.menugroup';
    private $model = 'menugroup';
    private $menuGroupModel;
    public function __construct()
    {
        $this->menuGroupModel = new MenuGroup();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = MENU_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $menus = $this->menuGroupModel::query()->get();
        $data['menus'] = $menus;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = MENU_GROUP_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MenuGroupRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới menu thành công.';
        $error   = 'Thêm mới menu thất bại.';

        $params = $this->menuGroupModel->revertAlias($request->all());
        $params['menugroup_code'] = UrlHelper::code($params['menugroup_name'], $request->code);

        try {
            $menu = $this->menuGroupModel::query()->create($params);

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create');
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $menu = $this->menuGroupModel::query()->where('menugroup_id', $id)->first();
        if($menu){
            $data['title'] = MENU_GROUP_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['menu'] = $menu;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy menu';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MenuGroupRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật menu thành công.';
        $error   = 'Cập nhật menu thất bại.';
        $params = $this->menuGroupModel->revertAlias(request()->post());
        $params['menugroup_code'] = UrlHelper::code($params['menugroup_name'], $request->code);

        try {
            $this->menuGroupModel::query()->where('menugroup_id', $id)->update($params);

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Xóa menu thành công.';
        $error   = 'Xóa menu thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->menuGroupModel->query()->whereIn('menugroup_id', $ids)->update(['menugroup_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->menuGroupModel->query(false)->whereIn('menugroup_id', $ids)->update(['menugroup_deleted_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function active(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Bật menu thành công.';
        $error   = 'Bật menu thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->menuGroupModel->query()->whereIn('menugroup_id', $ids)->update(['menugroup_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->menuGroupModel->query()->whereIn('menugroup_id', $ids)->update(['menugroup_updated_by' => $adminId]);  
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function inactive(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Tắt menu thành công.';
        $error   = 'Tắt menu thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->menuGroupModel->query()->whereIn('menugroup_id', $ids)->update(['menugroup_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->menuGroupModel->query()->whereIn('menugroup_id', $ids)->update(['menugroup_updated_by' => $adminId]);  
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
