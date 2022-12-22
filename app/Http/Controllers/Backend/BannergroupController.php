<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BannerGroupRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\BannerGroup;


class BannergroupController extends BaseController
{
    private $view = '.bannergroup';
    private $model = 'bannergroup';
    private $bannerGroupModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->bannerGroupModel = new BannerGroup();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = BANNER_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $groups = $this->bannerGroupModel::query()->where('bannergroup_parent', null)->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->bannerGroupModel->query()->where('bannergroup_id', $item->bannergroup_parent)->first();
                $item->parent = !empty($group) ? $group->bannergroup_name : '';
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
        $data['title'] = BANNER_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['parentId'] = $parentId;

        $groups = $this->bannerGroupModel::query()->where('bannergroup_parent', $parentId)->orderBy('bannergroup_id', 'asc')->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->bannerGroupModel->query()->where('bannergroup_id', $item->bannergroup_parent)->first();
                $item->parent = !empty($group) ? $group->bannergroup_name : '';
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
        $data['title'] = BANNER_GROUP_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        $data['code'] = '';
        // Begin Nested items
        $data['parents'] = $this->bannerGroupModel::where('bannergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BannerGroupRequest $request)
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
        $success = 'Đã thêm mới nhóm banner thành công.';
        $error   = 'Thêm mới nhóm banner thất bại.';

        $params = $this->bannerGroupModel->revertAlias($request->all());
        $params['bannergroup_slug'] = UrlHelper::postSlug($params['bannergroup_name'], $request->slug);
        $params['bannergroup_url'] = $params['bannergroup_slug'].SUFFIX_URL;

        try {
            $bannergroup = $this->bannerGroupModel::query()->create($params);

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

        $group = $this->bannerGroupModel::query()->where('bannergroup_id', $id)->first();
        if($group){
            $data['title'] = 'Quản lý nhóm banner[Sao Chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['group'] = $group;

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->bannerGroupModel::where('bannergroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $group->bannergroup_parent;
            // End Nested items
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm banner';
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
        $group = $this->bannerGroupModel::query()->where('bannergroup_id', $id)->first();
        if($group){
            $data['title'] = 'Quản lý nhóm banner[Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['group'] = $group;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->bannerGroupModel::where('bannergroup_parent', null)->where('bannergroup_id','!=',$id)->with('childItems')->get();
            $data['parentId'] = $group->bannergroup_parent;
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm banner';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param BannerGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BannerGroupRequest $request)
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

        $success = 'Cập nhật nhóm banner thành công.';
        $error   = 'Cập nhật nhóm banner thất bại.';

        $params = $this->bannerGroupModel->revertAlias(request()->post());
        $params['bannergroup_slug'] = UrlHelper::postSlug($params['bannergroup_name'], $request->slug);
        $params['bannergroup_url'] = $params['bannergroup_slug'].SUFFIX_URL;

        try {
            $this->bannerGroupModel::query()->where('bannergroup_id', $id)->update($params);

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
    public function duplicate(BannerGroupRequest $request)
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

        $success = 'Sao chép nhóm banner thành công.';
        $error   = 'Sao chép nhóm banner thất bại.';

        $params = $this->bannerGroupModel->revertAlias($request->all());
        $params['bannergroup_slug'] = UrlHelper::postSlug($params['bannergroup_name'], $request->slug);
        $params['bannergroup_url'] = $params['bannergroup_slug'].SUFFIX_URL;
        unset($params['bannergroup_id']);

        try {
            $bannergroup = $this->bannerGroupModel::query()->create($params);

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
        $success = 'Xóa banner thành công.';
        $error   = 'Xóa banner thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $groups = $this->bannerGroupModel->query()->whereIn('bannergroup_id', $ids)->get();
        foreach($groups as $key => $item)
        {
            if($item->childItems->count() > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Đã tồn tại child items');
            }
        }
        $number = $this->bannerGroupModel->query()->whereIn('bannergroup_id', $ids)->update(['bannergroup_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->bannerGroupModel->query(false)->whereIn('bannergroup_id', $ids)->update(['bannergroup_deleted_by' => $adminId]);
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
        $success = 'Bật nhóm banner thành công.';
        $error   = 'Bật nhóm banner thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->bannerGroupModel->query()->whereIn('bannergroup_id', $ids)->update(['bannergroup_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->bannerGroupModel->query()->whereIn('bannergroup_id', $ids)->update(['bannergroup_updated_by' => $adminId]);
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
        $success = 'Tắt nhóm banner thành công.';
        $error   = 'Tắt nhóm banner thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->bannerGroupModel->query()->whereIn('bannergroup_id', $ids)->update(['bannergroup_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->bannerGroupModel->query()->whereIn('bannergroup_id', $ids)->update(['bannergroup_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
