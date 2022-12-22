<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdvertGroupRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdvertGroup;


class AdvertgroupController extends BaseController
{
    private $view = '.advertgroup';
    private $model = 'advertgroup';
    private $advertGroupModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->advertGroupModel = new AdvertGroup();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = ADVERT_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $groups = $this->advertGroupModel::query()->where('adgroup_parent', null)->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->advertGroupModel->query()->where('adgroup_id', $item->adgroup_parent)->first();
                $item->parent = !empty($group) ? $group->adgroup_name : '';
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
        $data['title'] = ADVERT_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['parentId'] = $parentId;

        $groups = $this->advertGroupModel::query()->where('adgroup_parent', $parentId)->orderBy('adgroup_id', 'asc')->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->advertGroupModel->query()->where('adgroup_id', $item->adgroup_parent)->first();
                $item->parent = !empty($group) ? $group->adgroup_name : '';
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
        $data['title'] = ADVERT_GROUP_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        // Begin Nested items
        $data['parents'] = $this->advertGroupModel::where('adgroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdvertGroupRequest $request)
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

        $success = 'Đã thêm mới nhóm quảng cáo thành công.';
        $error   = 'Thêm mới nhóm quảng cáo thất bại.';

        $params = $this->advertGroupModel->revertAlias($request->all());
        $params['adgroup_slug'] = UrlHelper::postSlug($params['adgroup_name'], $request->slug);
        $params['adgroup_url'] = $params['adgroup_slug'].SUFFIX_URL;

        try {
            $adgroup = $this->advertGroupModel::query()->create($params);

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

        $adgroup = $this->advertGroupModel::query()->where('adgroup_id', $id)->first();
        if($adgroup){
            $data['title'] = ADVERT_GROUP_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['adgroup'] = $adgroup;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->advertGroupModel::where('adgroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $adgroup->adgroup_parent;
            // End Nested items

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm quảng cáo';
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
        $adgroup = $this->advertGroupModel::query()->where('adgroup_id', $id)->first();
        if($adgroup){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $adgroup->adgroup_created_by)->first();
            $data['title'] = ADVERT_GROUP_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['adgroup'] = $adgroup;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->advertGroupModel::where('adgroup_parent', null)->where('adgroup_id','!=',$id)->with('childItems')->get();
            $data['parentId'] = $adgroup->adgroup_parent;
            // End Nested items
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm quảng cáo';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param AdvertGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdvertGroupRequest $request)
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

        $success = 'Cập nhật nhóm quảng cáo thành công.';
        $error   = 'Cập nhật nhóm quảng cáo thất bại.';
        $params = $this->advertGroupModel->revertAlias(request()->post());
        $params['adgroup_slug'] = UrlHelper::postSlug($params['adgroup_name'], $request->slug);
        $params['adgroup_url'] = $params['adgroup_slug'].SUFFIX_URL;

        try {
            $this->advertGroupModel::query()->where('adgroup_id', $id)->update($params);

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
    public function duplicate(AdvertGroupRequest $request)
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

        $success = 'Sao chép nhóm quảng cáo thành công.';
        $error   = 'Sao chép nhóm quảng cáo thất bại.';

        $params = $this->advertGroupModel->revertAlias($request->all());
        $params['adgroup_slug'] = UrlHelper::postSlug($params['adgroup_name'], $request->slug);
        $params['adgroup_url'] = $params['adgroup_slug'].SUFFIX_URL;
        unset($params['adgroup_id']);

        try {
            $adgroup = $this->advertGroupModel::query()->create($params);

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
        $success = 'Xóa quảng cáo thành công.';
        $error   = 'Xóa quảng cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $groups = $this->advertGroupModel->query()->whereIn('adgroup_id', $ids)->get();
        foreach($groups as $key => $item)
        {
            if($item->childItems->count() > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Đã tồn tại child items');
            }
        }
        $number = $this->advertGroupModel->query()->whereIn('adgroup_id', $ids)->update(['adgroup_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->advertGroupModel->query(false)->whereIn('adgroup_id', $ids)->update(['adgroup_deleted_by' => $adminId]);
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
        $success = 'Bật nhóm quảng cáo thành công.';
        $error   = 'Bật nhóm quảng cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->advertGroupModel->query()->whereIn('adgroup_id', $ids)->update(['adgroup_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->advertGroupModel->query()->whereIn('adgroup_id', $ids)->update(['adgroup_updated_by' => $adminId]);
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
        $success = 'Tắt nhóm quảng cáo thành công.';
        $error   = 'Tắt nhóm quảng cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->advertGroupModel->query()->whereIn('adgroup_id', $ids)->update(['adgroup_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->advertGroupModel->query()->whereIn('adgroup_id', $ids)->update(['adgroup_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
