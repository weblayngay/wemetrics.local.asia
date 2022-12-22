<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Models\PostGroup;
use App\Models\Image;
use App\Models\AdminUser;


class PostgroupController extends BaseController
{
    private $view = '.postgroup';
    private $model = 'postgroup';
    private $postGroupModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->postGroupModel = new PostGroup();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = POST_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');

        $groups = $this->postGroupModel::query()->where('postgroup_parent', null)->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->postGroupModel->query()->where('postgroup_id', $item->postgroup_parent)->first();
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->parent = !empty($group) ? $group->postgroup_name : '';
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
        $data['title'] = POST_GROUP_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');
        $data['parentId'] = $parentId;

        $groups = $this->postGroupModel::query()->where('postgroup_parent', $parentId)->orderBy('postgroup_id', 'asc')->get();
        if($groups->count() > 0){
            foreach ($groups as $key => $item){
                $group  = $this->postGroupModel->query()->where('postgroup_id', $item->postgroup_parent)->first();
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->parent = !empty($group) ? $group->postgroup_name : '';
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
        $data['title'] = POST_GROUP_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['groups'] = $this->postGroupModel::query()->get();
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        // Begin Nested items
        $data['parents'] = $this->postGroupModel::where('postgroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
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
        $success = 'Đã thêm mới nhóm bài viết thành công.';
        $error   = 'Thêm mới nhóm bài viết thất bại.';

        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->postGroupModel->revertAlias($request->all());
        $params['postgroup_slug'] = UrlHelper::postSlug($params['postgroup_name'], $request->slug);
        $params['postgroup_url'] = $params['postgroup_slug'].SUFFIX_URL;

        try {
            $groupId = 0;
            $group = $this->postGroupModel::query()->create($params);
            if($group){
                $groupId = $group->postgroup_id;
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
        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');;

        $group = $this->postGroupModel::query()->where('postgroup_id', $id)->first();
        if($group){
            $data['title'] = POST_GROUP_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['group'] = $group;
            $data['urlAvatar'] = '';
            $data['groups'] = $this->postGroupModel::query()->where('postgroup_id','!=', $id)->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->postGroupModel::where('postgroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $group->postgroup_parent;
            // End Nested items
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm nhóm thấy bài viết';
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
        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');;

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $group = $this->postGroupModel::query()->where('postgroup_id', $id)->first();
        if($group){
            $data['title'] = POST_GROUP_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['group'] = $group;
            $data['urlAvatar'] = '';
            $data['groups'] = $this->postGroupModel::query()->where('postgroup_id','!=', $id)->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->postGroupModel::where('postgroup_parent', null)->where('postgroup_id','!=',$id)->with('childItems')->get();
            $data['parentId'] = $group->postgroup_parent;
            // End Nested items
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhóm bài viết';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request)
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
        $success = 'Cập nhật nhóm bài viết thành công.';
        $error   = 'Cập nhật nhóm bài viết thất bại.';

        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->postGroupModel->revertAlias(request()->post());
        $params['postgroup_slug'] = UrlHelper::postSlug($params['postgroup_name'], $request->slug);
        $params['postgroup_url'] = $params['postgroup_slug'].SUFFIX_URL;
        $params['postgroup_description'] = $params['postgroup_description'] ?? '';

        try {
            $this->postGroupModel::query()->where('postgroup_id', $id)->update($params);

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
    public function duplicate(PostRequest $request)
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

        $success = 'Sao chép nhóm bài viết thành công.';
        $error   = 'Sao chép nhóm bài viết thất bại.';
        
        $pathAvatar = config('my.path.image_postgroup_of_module');
        $valueAvatar = config('my.image.value.postgroup.avatar');;
        $pathSave = $this->model.'_m';

        $params = $this->postGroupModel->revertAlias($request->all());
        $params['postgroup_slug'] = UrlHelper::postSlug($params['postgroup_name'], $request->slug);
        $params['postgroup_url'] = $params['postgroup_slug'].SUFFIX_URL;
        unset($params['postgroup_id']);

        try {
            $groupId = 0;
            $group = $this->postGroupModel::query()->create($params);
            if($group){
                $groupId = $group->postgroup_id;
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
        $success = 'Xóa nhóm bài viết thành công.';
        $error   = 'Xóa nhóm bài viết thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $groups = $this->postGroupModel->query()->whereIn('postgroup_id', $ids)->get();
        foreach($groups as $key => $item)
        {
            if($item->childItems->count() > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Đã tồn tại child items');
            }
        }
        $number = $this->postGroupModel->query()->whereIn('postgroup_id', $ids)->update(['postgroup_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->postGroupModel->query(false)->whereIn('postgroup_id', $ids)->update(['postgroup_deleted_by' => $adminId]);
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
        $success = 'Bật nhóm bài viết thành công.';
        $error   = 'Bật nhóm bài viết thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->postGroupModel->query()->whereIn('postgroup_id', $ids)->update(['postgroup_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->postGroupModel->query()->whereIn('postgroup_id', $ids)->update(['postgroup_updated_by' => $adminId]);
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
        $success = 'Tắt nhóm bài viết thành công.';
        $error   = 'Tắt nhóm bài viết thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->postGroupModel->query()->whereIn('postgroup_id', $ids)->update(['postgroup_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->postGroupModel->query()->whereIn('postgroup_id', $ids)->update(['postgroup_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
