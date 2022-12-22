<?php

namespace App\Http\Controllers\Backend\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CampaignGroupRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\CampaignGroup;
use App\Models\Campaign;

class CampaigngroupController extends BaseController
{
    private $view = '.campaigngroup';
    private $model = 'campaigngroup';
    private $campaignGroupModel;
    private $campaignModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->campaignGroupModel = new CampaignGroup();
        $this->campaignModel = new Campaign();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CAMPAIGN_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');

        $groups = $this->campaignGroupModel::query()->where('campaigngroup_parent', null)->paginate(PAGINATE_PERPAGE);
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->campaignGroupModel->query()->where('campaigngroup_id', $item->campaigngroup_parent)->first();
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->parent = !empty($group) ? $group->campaigngroup_name : '';
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
        $data['title'] = CAMPAIGN_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');
        $data['parentId'] = $parentId;

        $groups = $this->campaignGroupModel::query()->where('campaigngroup_parent', $parentId)->paginate(PAGINATE_PERPAGE);
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->campaignGroupModel->query()->where('campaigngroup_id', $item->campaigngroup_parent)->first();
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->parent = !empty($group) ? $group->campaigngroup_name : '';
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
        $data['title'] = CAMPAIGN_GROUP_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['groups'] = $this->campaignGroupModel::query()->get();
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        // Begin Nested items
        $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CampaignGroupRequest $request)
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
        $success = 'Đã thêm mới nhóm chiến dịch thành công.';
        $error   = 'Thêm mới nhóm chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->campaignGroupModel->revertAlias($request->all());

        try {
            $groupId = 0;
            $group = $this->campaignGroupModel::query()->create($params);
            if($group){
                $groupId = $group->campaigngroup_id;
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
        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');;

        $group = $this->campaignGroupModel::query()->where('campaigngroup_id', $id)->first();
        if($group){
            $data['title'] = CAMPAIGN_GROUP_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['group'] = $group;
            $data['urlAvatar'] = '';
            $data['groups'] = $this->campaignGroupModel::query()->where('campaigngroup_id','!=', $id)->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $group->campaigngroup_parent;
            // End Nested items
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm nhóm thấy chiến dịch';
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
        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');;

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $group = $this->campaignGroupModel::query()->where('campaigngroup_id', $id)->first();
        if($group){
            $data['title'] = CAMPAIGN_GROUP_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['group'] = $group;
            $data['urlAvatar'] = '';
            $data['groups'] = $this->campaignGroupModel::query()->where('campaigngroup_id','!=', $id)->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->where('campaigngroup_id','!=',$id)->with('childItems')->get();
            $data['parentId'] = $group->campaigngroup_parent;
            // End Nested items
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm chiến dịch';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param CampaignGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CampaignGroupRequest $request)
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
        $success = 'Cập nhật nhóm chiến dịch thành công.';
        $error   = 'Cập nhật nhóm chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->campaignGroupModel->revertAlias(request()->post());

        try {
            $this->campaignGroupModel::query()->where('campaigngroup_id', $id)->update($params);

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
    public function duplicate(CampaignGroupRequest $request)
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

        $success = 'Sao chép nhóm chiến dịch thành công.';
        $error   = 'Sao chép nhóm chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->campaignGroupModel->revertAlias($request->all());
        unset($params['campaigngroup_id']);

        try {
            $groupId = 0;
            $group = $this->campaignGroupModel::query()->create($params);
            if($group){
                $groupId = $group->campaigngroup_id;
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
        $success = 'Xóa nhóm chiến dịch thành công.';
        $error   = 'Xóa nhóm chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $groups = $this->campaignGroupModel->query()->whereIn('campaigngroup_id', $ids)->get();
        foreach($groups as $key => $item)
        {
            if($item->childItems->count() > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Đã tồn tại child items');
            }

            if(!empty($item->campaigns) && count($item->campaigns) > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Tồn tại nhóm chiến dịch đã được sử dụng');
            }
        }
        $number = $this->campaignGroupModel->query()->whereIn('campaigngroup_id', $ids)->update(['campaigngroup_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignGroupModel->query(false)->whereIn('campaigngroup_id', $ids)->update(['campaigngroup_deleted_by' => $adminId]);
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
        $success = 'Bật nhóm chiến dịch thành công.';
        $error   = 'Bật nhóm chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->campaignGroupModel->query()->whereIn('campaigngroup_id', $ids)->update(['campaigngroup_status' => 'activated']);

        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignGroupModel->query()->whereIn('campaigngroup_id', $ids)->update(['campaigngroup_updated_by' => $adminId]);
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
        $success = 'Tắt nhóm chiến dịch thành công.';
        $error   = 'Tắt nhóm chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->campaignGroupModel->query()->whereIn('campaigngroup_id', $ids)->update(['campaigngroup_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignGroupModel->query()->whereIn('campaigngroup_id', $ids)->update(['campaigngroup_updated_by' => $adminId]);
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
        $columnArr = ['campaigngroup_name', 'campaigngroup_description'];
        foreach($columnArr as $key => $column)
        {
            $groups = $this->campaignGroupModel::search($column, $searchStr, $status, $isUsed, $paginateNum);
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

        $data['title'] = CAMPAIGN_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';
        $data['groups']  = $this->campaignGroupModel::query()->select('campaigngroup_id','campaigngroup_name')->where('campaigngroup_status', 'activated')->get();

        $pathAvatar = config('my.path.image_campaigngroup_of_module');
        $valueAvatar = config('my.image.value.campaigngroup.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $groups = $this->searchQuery($searchStr, $status, $isUsed, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['groups'] = !empty($groups) ? CollectionPaginateHelper::paginate($groups, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }
}
