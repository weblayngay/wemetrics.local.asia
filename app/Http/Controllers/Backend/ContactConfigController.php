<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ContactConfigRequest;
use App\Models\AdminUser;
use App\Models\ContactConfig;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactConfigController extends BaseController
{
    private $view = '.contactconfig';
    private $model = 'contactconfig';
    private $contactconfigModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->contactconfigModel = new ContactConfig();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CONTACT_CONFIG_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $contactconfigs = $this->contactconfigModel::query()->orderBy('contactconfig_id', 'DESC')->paginate(50);
        $data['contactconfigs'] = $contactconfigs;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $contactconfig = $this->contactconfigModel->query(true)->first();
        if(!empty($contactconfig))
        {
            $error   = 'Đã tồn tại cấu hình liên hệ';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        } else {
            $data['title'] = CONTACT_CONFIG_TITLE.ADD_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.add';
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id; 
            return view($data['view'] , compact('data')); 
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactConfigRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }
        $success = 'Đã thêm mới liên hệ thành công.';
        $error   = 'Thêm mới liên hệ thất bại.';
        $user = Auth::guard('admin')->user();
        $params = $this->contactconfigModel->revertAlias($request->all());
        try {
            $contactconfig = $this->contactconfigModel::query()->create($params);
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
        $contactconfig = $this->contactconfigModel::query()->where('contactconfig_id', $id)->first();
        if($contactconfig){
            $data['title'] = CONTACT_CONFIG_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['contactconfig'] = $contactconfig;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;            
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy liên hệ';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactConfigRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }
        $success = 'Cập nhật liên hệ thành công.';
        $error   = 'Cập nhật liên hệ thất bại.';
        $params = $this->contactconfigModel->revertAlias(request()->post());
        try {
            $this->contactconfigModel::query()->where('contactconfig_id', $id)->update($params);
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
        $success = 'Xóa liên hệ thành công.';
        $error   = 'Xóa liên hệ thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->contactconfigModel->query()->whereIn('contactconfig_id', $ids)->update(['contactconfig_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactconfigModel->query(false)->whereIn('contactconfig_id', $ids)->update(['contactconfig_deleted_by' => $adminId]);
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
        $success = 'Bật liên hệ thành công.';
        $error   = 'Bật liên hệ thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->contactconfigModel->query()->whereIn('contactconfig_id', $ids)->update(['contactconfig_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactconfigModel->query()->whereIn('contactconfig_id', $ids)->update(['contactconfig_updated_by' => $adminId]);
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
        $success = 'Tắt liên hệ thành công.';
        $error   = 'Tắt liên hệ thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->contactconfigModel->query()->whereIn('contactconfig_id', $ids)->update(['contactconfig_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactconfigModel->query()->whereIn('contactconfig_id', $ids)->update(['contactconfig_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
