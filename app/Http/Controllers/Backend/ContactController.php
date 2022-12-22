<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ContactRequest;
use App\Models\AdminUser;
use App\Models\Contact;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactController extends BaseController
{
    private $view = '.contact';
    private $model = 'contact';
    private $contactModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->contactModel = new Contact();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CONTACT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $contacts = $this->contactModel::query()->orderBy('contact_id', 'DESC')->paginate(50);
        $data['contacts'] = $contacts;
        return view($data['view'] , compact('data'));
    }

    /**
     * Lấy danh sach theo $type
     * @return Application|Factory|View
     */
    public function type()
    {
        return view($this->viewPath . $this->view . '.type');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CONTACT_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
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
        $params = $this->contactModel->revertAlias($request->all());
        try {
            $contact = $this->contactModel::query()->create($params);
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create');
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function copy()
    {
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $contact = $this->contactModel::query()->where('contact_id', $id)->first();
        if($contact){
            $data['title'] = CONTACT_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['contact'] = $contact;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy mã giảm giá';
            $redirect = UrlHelper::admin($this->model);
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
        $contact = $this->contactModel::query()->where('contact_id', $id)->first();
        if($contact){
            $data['title'] = CONTACT_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['contact'] = $contact;
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
    public function update(ContactRequest $request)
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
        $params = $this->contactModel->revertAlias(request()->post());
        try {
            $this->contactModel::query()->where('contact_id', $id)->update($params);
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(ContactRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }
        $success = 'Sao chép mã giảm giá thành công.';
        $error   = 'Sao chép mã giảm giá thất bại.';
        $params = $this->contactModel->revertAlias($request->all());
        unset($params['contact_id']);
        try {
            $contactId = 0;
            $contact = $this->contactModel::query()->create($params);
            if($contact){
                $contactId = $contact->contact_id;
            }
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
        $number = $this->contactModel->query()->whereIn('contact_id', $ids)->update(['contact_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactModel->query(false)->whereIn('contact_id', $ids)->update(['contact_deleted_by' => $adminId]);
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
        $number = $this->contactModel->query()->whereIn('contact_id', $ids)->update(['contact_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactModel->query()->whereIn('contact_id', $ids)->update(['contact_updated_by' => $adminId]);
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
        $number = $this->contactModel->query()->whereIn('contact_id', $ids)->update(['contact_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactModel->query()->whereIn('contact_id', $ids)->update(['contact_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
