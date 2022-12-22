<?php

namespace App\Http\Controllers\Backend\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VoucherGroupRequest;
use App\Models\AdminUser;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Models\VoucherGroup;
use App\Models\Voucher;
use App\Models\Image;


class VouchergroupController extends BaseController
{
    private $view = '.vouchergroup';
    private $model = 'vouchergroup';
    private $voucherGroupModel;
    private $voucherModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->voucherGroupModel = new VoucherGroup();
        $this->voucherModel = new Voucher();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = VOUCHER_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');

        $groups = $this->voucherGroupModel::query()->where('vouchergroup_parent', null)->paginate(PAGINATE_PERPAGE);
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->voucherGroupModel->query()->where('vouchergroup_id', $item->vouchergroup_parent)->first();
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->parent = !empty($group) ? $group->vouchergroup_name : '';
            }
        }
        $data['groups'] = $groups;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function drill()
    {
        $parentId = \request()->get('parentId');
        $data['title'] = VOUCHER_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');
        $data['parentId'] = $parentId;

        $groups = $this->voucherGroupModel::query()->where('vouchergroup_parent', $parentId)->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->voucherGroupModel->query()->where('vouchergroup_id', $item->vouchergroup_parent)->first();
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->parent = !empty($group) ? $group->vouchergroup_name : '';
            }
        }
        $data['groups'] = $groups;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = VOUCHER_GROUP_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['groups'] = $this->voucherGroupModel::query()->get();
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        // Begin Nested items
        $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(VoucherGroupRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $parent = request()->post('parent', 0);
        if($parent == 0)
        {
            if($actionType == 'save'){
                $redirect = UrlHelper::admin($this->model);
            }else{
                $redirect = UrlHelper::admin($this->model,'create');
            }
        }
        else
        {
            if($actionType == 'save'){
                $redirect = UrlHelper::admin($this->model, 'drill?parentId='.$parent);
            }else{
                $redirect = UrlHelper::admin($this->model,'create');
            }
        }
        $success = 'Đã thêm mới nhóm mã giảm giá thành công.';
        $error   = 'Thêm mới nhóm mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->voucherGroupModel->revertAlias($request->all());

        try {
            $groupId = 0;
            $group = $this->voucherGroupModel::query()->create($params);
            if($group){
                $groupId = $group->vouchergroup_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $groupId, $valueAvatar, $pathSave);
            }

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
        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');;

        $group = $this->voucherGroupModel::query()->where('vouchergroup_id', $id)->first();
        if($group){
            $data['title'] = VOUCHER_GROUP_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['group'] = $group;
            $data['urlAvatar'] = '';
            $data['groups'] = $this->voucherGroupModel::query()->where('vouchergroup_id','!=', $id)->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $group->vouchergroup_parent;
            // End Nested items
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm nhóm thấy mã giảm giá';
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
        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');;

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $group = $this->voucherGroupModel::query()->where('vouchergroup_id', $id)->first();
        if($group){
            $data['title'] = VOUCHER_GROUP_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['group'] = $group;
            $data['urlAvatar'] = '';
            $data['groups'] = $this->voucherGroupModel::query()->where('vouchergroup_id','!=', $id)->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->where('vouchergroup_id','!=',$id)->with('childItems')->get();
            $data['parentId'] = $group->vouchergroup_parent;
            // End Nested items
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm mã giảm giá';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param VoucherGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(VoucherGroupRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        $parent = request()->post('parent', 0);
        if($parent == 0)
        {
            if($actionType == 'save'){
                $redirect = UrlHelper::admin($this->model);
            }else{
                $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
            }
        }
        else
        {
            if($actionType == 'save'){
                $redirect = UrlHelper::admin($this->model, 'drill?parentId='.$parent);
            }else{
                $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
            }
        }
        $success = 'Cập nhật nhóm mã giảm giá thành công.';
        $error   = 'Cập nhật nhóm mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->voucherGroupModel->revertAlias(request()->post());

        try {
            $this->voucherGroupModel::query()->where('vouchergroup_id', $id)->update($params);

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(VoucherGroupRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        $parent = request()->post('parent', 0);
        if($parent == 0)
        {
            if($actionType == 'save'){
                $redirect = UrlHelper::admin($this->model);
            }else{
                $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
            }
        }
        else
        {
            if($actionType == 'save'){
                $redirect = UrlHelper::admin($this->model, 'drill?parentId='.$parent);
            }else{
                $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
            }
        }

        $success = 'Sao chép nhóm mã giảm giá thành công.';
        $error   = 'Sao chép nhóm mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->voucherGroupModel->revertAlias($request->all());
        unset($params['vouchergroup_id']);

        try {
            $groupId = 0;
            $group = $this->voucherGroupModel::query()->create($params);
            if($group){
                $groupId = $group->vouchergroup_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $groupId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $groupId;
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
        $success = 'Xóa nhóm mã giảm giá thành công.';
        $error   = 'Xóa nhóm mã giảm giá thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $groups = $this->voucherGroupModel->query()->whereIn('vouchergroup_id', $ids)->get();
        foreach($groups as $key => $item)
        {
            if($item->childItems->count() > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Đã tồn tại child items');
            }
        }
        $number = $this->voucherGroupModel->query()->whereIn('vouchergroup_id', $ids)->update(['vouchergroup_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->voucherGroupModel->query(false)->whereIn('vouchergroup_id', $ids)->update(['vouchergroup_deleted_by' => $adminId]);
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
        $success = 'Bật nhóm mã giảm giá thành công.';
        $error   = 'Bật nhóm mã giảm giá thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->voucherGroupModel->query()->whereIn('vouchergroup_id', $ids)->update(['vouchergroup_status' => 'activated']);

        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->voucherGroupModel->query()->whereIn('vouchergroup_id', $ids)->update(['vouchergroup_updated_by' => $adminId]);
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
        $success = 'Tắt nhóm mã giảm giá thành công.';
        $error   = 'Tắt nhóm mã giảm giá thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->voucherGroupModel->query()->whereIn('vouchergroup_id', $ids)->update(['vouchergroup_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->voucherGroupModel->query()->whereIn('vouchergroup_id', $ids)->update(['vouchergroup_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $status, string $isUsed, int $paginateNum)
    {
        $columnArr = ['vouchergroup_name', 'vouchergroup_description'];
        foreach($columnArr as $key => $column)
        {
            $groups = $this->voucherGroupModel::search($column, $searchStr, $status, $isUsed, $paginateNum);
            if(!empty($groups) && count($groups) > 0)
            {
                return $groups;
                break;
            }
        }
        return null; //If can not find any records follow the column;
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $searchStr = (string) strip_tags(request()->post('searchStr', ''));
        $isUsed = (string) strip_tags(request()->post('isUsed', ''));
        $status = (string) strip_tags(request()->post('status', ''));

        $data['title'] = VOUCHER_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';
        $data['groups']  = $this->voucherGroupModel::query()->select('vouchergroup_id','vouchergroup_name')->where('vouchergroup_status', 'activated')->get();

        $pathAvatar = config('my.path.image_vouchergroup_of_module');
        $valueAvatar = config('my.image.value.vouchergroup.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $groups = $this->searchQuery($searchStr, $status, $isUsed, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['groups'] = !empty($groups) ? CollectionPaginateHelper::paginate($groups, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }
}
