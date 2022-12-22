<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ContactExtendRequest;
use App\Models\AdminUser;
use App\Models\ContactExtend;
use App\Models\Image;
use App\Helpers\UrlHelper;
use App\Helpers\ImageHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactExtendController extends BaseController
{
    private $view = '.contactextend';
    private $model = 'contactextend';
    private $contactextendModel;
    private $adminUserModel;
    private $imageModel;
    public function __construct()
    {
        $this->contactextendModel = new ContactExtend();
        $this->adminUserModel = new AdminUser();
        $this->imageModel = new Image();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CONTACT_EXTEND_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_contactextend_of_module');
        $valueAvatar = config('my.image.value.contactextend.avatar');

        $contactextends = $this->contactextendModel::query()->orderBy('contactextend_id', 'DESC')->paginate(50);
        if($contactextends->count() > 0){
            foreach ($contactextends as $key => $item){
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
            }
        }
        $data['contactextends'] = $contactextends;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $contactextend = $this->contactextendModel->query(true)->first();
        if(!empty($contactextend))
        {
            $error   = 'Đã tồn tại cấu hình liên hệ';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        } else {
            $data['title'] = CONTACT_EXTEND_TITLE.ADD_LABEL;
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
    public function store(ContactExtendRequest $request)
    {
        $pathAvatar = config('my.path.image_contactextend_of_module');
        $valueAvatar = config('my.image.value.contactextend.avatar');
        $pathSave = $this->model.'_m';

        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới liên hệ thành công.';
        $error   = 'Thêm mới liên hệ thất bại.';

        $user = Auth::guard('admin')->user();
        $params = $this->contactextendModel->revertAlias($request->all());

        try {
            $contactextendId = 0;
            $contactextend = $this->contactextendModel::query()->create($params);
            if($contactextend){
                $contactextendId = $contactextend->contactextend_id;
            }
            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $contactextendId, $valueAvatar, $pathSave);
            }            
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create');
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function copy()
    {
        $pathAvatar = config('my.path.image_contactextend_of_module');
        $valueAvatar = config('my.image.value.contactextend.avatar');

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();

        $contactextend = $this->contactextendModel::query()->where('contactextend_id', $id)->first();

        if($contactextend){
            $data['title'] = CONTACT_EXTEND_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['contactextend'] = $contactextend;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            $data['urlAvatar'] = '';
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy liên hệ';
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
        $pathAvatar = config('my.path.image_contactextend_of_module');
        $valueAvatar = config('my.image.value.contactextend.avatar');

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();

        $contactextend = $this->contactextendModel::query()->where('contactextend_id', $id)->first();

        if($contactextend){
            $data['title'] = CONTACT_EXTEND_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['contactextend'] = $contactextend;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            $data['urlAvatar'] = '';
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }                                               
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
    public function update(ContactExtendRequest $request)
    {
        $pathAvatar = config('my.path.image_contactextend_of_module');
        $valueAvatar = config('my.image.value.contactextend.avatar');
        $pathSave = $this->model.'_m';

        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật liên hệ thành công.';
        $error   = 'Cập nhật liên hệ thất bại.';

        $params = $this->contactextendModel->revertAlias(request()->post());

        try {
            $this->contactextendModel::query()->where('contactextend_id', $id)->update($params);
            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;

                /**check image exist*/
                $image = Image::query()->where(['3rd_key' => $id, '3rd_type' => $this->model,  'image_value' => $valueAvatar])->first();
                if($image){
                    ImageHelper::uploadUpdateImage($imageAvatar, $valueAvatar, $image->image_id, $pathSave);
                }else{
                    ImageHelper::uploadImage($imageAvatar, $this->model, $id, $valueAvatar, $pathSave);
                }
            }
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ContactExtendRequest $request
     * @return RedirectResponse
     */
    public function duplicate(ContactExtendRequest $request)
    {
        $pathAvatar = config('my.path.image_contactextend_of_module');
        $valueAvatar = config('my.image.value.contactextend.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép liên hệ thành công.';
        $error   = 'Sao chép liên hệ thất bại.';

        $params = $this->contactextendModel->revertAlias($request->all());
        unset($params['contactextend_id']);

        try {
            $contactextendId = 0;
            $contactextend = $this->contactextendModel::query()->create($params);
            if($contactextend){
                $contactextendId = $contactextend->contactextend_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $contactextendId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $contactextendId;
                    $imageAvatar['3rd_type'] = $this->model;
                    $this->imageModel->query()->create($imageAvatar);
                }

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
        $number = $this->contactextendModel->query()->whereIn('contactextend_id', $ids)->update(['contactextend_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactextendModel->query(false)->whereIn('contactextend_id', $ids)->update(['contactextend_deleted_by' => $adminId]);
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
        $number = $this->contactextendModel->query()->whereIn('contactextend_id', $ids)->update(['contactextend_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactextendModel->query()->whereIn('contactextend_id', $ids)->update(['contactextend_updated_by' => $adminId]);
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
        $number = $this->contactextendModel->query()->whereIn('contactextend_id', $ids)->update(['contactextend_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->contactextendModel->query()->whereIn('contactextend_id', $ids)->update(['contactextend_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sort(Request $request)
    {
        $ids     = request()->post('cid', []);
        $sorts   = request()->post('sort', []);
        $redirect = UrlHelper::admin($this->model, 'index');

        if (!is_array($ids) || count($ids) == 0) {
            return redirect()->to($redirect)->with('error', 'Vui lòng chọn giá trị để sắp xếp');
        }

        foreach ($ids as $key => $id) {
            $this->contactextendModel::parentQuery()->where('contactextend_id', $id)->update(['contactextend_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp liên hệ thành công');
    }
}
