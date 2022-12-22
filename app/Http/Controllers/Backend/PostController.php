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
use App\Models\Post;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\PostGroup;


class PostController extends BaseController
{
    private $view = '.post';
    private $model = 'post';
    private $postModel;
    private $postGroupModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->postModel = new Post();
        $this->imageModel = new Image();
        $this->postGroupModel = new PostGroup();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = POST_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_post_avatar_of_module');
        $valueAvatar = config('my.image.value.post.avatar');

        $posts = $this->postModel::query()->get();
        if($posts->count() > 0){
            foreach ($posts as $key => $item){
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $group = $this->postGroupModel->query()->where('postgroup_id', $item->post_group)->first();
                $item->groupName = !empty($group->postgroup_name) ? $group->postgroup_name : '';
            }
        }
        $data['posts'] = $posts;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = POST_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['posts'] = $this->postModel::query()->get();
        $data['groups'] = $this->postGroupModel::query()->get();

        $data['url'] = '';
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
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới bài viết thành công.';
        $error   = 'Thêm mới bài viết thất bại.';

        $pathAvatar = config('my.path.image_post_avatar_of_module');
        $valueAvatar = config('my.image.value.post.avatar');
        $pathSave = $this->model.'_m/avatar';

        $user = Auth::guard('admin')->user();

        $params = $this->postModel->revertAlias($request->all());
        $params['post_slug'] = UrlHelper::postSlug($params['post_name'], $request->slug);
        $params['post_url'] = $params['post_slug'].SUFFIX_URL;

        if($request->related){
            $params['post_related'] = array_diff(array_map('intval', $params['post_related']), [0]);
            $params['post_related'] = implode(",", $params['post_related']);
        }

        try {
            $postId = 0;
            $post = $this->postModel::query()->create($params);
            if($post){
                $postId = $post->post_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $postId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_post_avatar_of_module');
        $valueAvatar = config('my.image.value.post.avatar');

        $post = $this->postModel::query()->where('post_id', $id)->first();
        if($post){
            $data['title'] = POST_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['post'] = $post;
            $data['urlAvatar'] = '';

            $data['posts'] = $this->postModel::query()->where([['post_id','!=', $id]])->get();
            $data['arrayRelated'] = !empty($post->post_related) ? explode(',', $post->post_related) : [];

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups'] = $this->postGroupModel::query()->get();
            
            // Begin Nested items
            $data['parents'] = $this->postGroupModel::where('postgroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $post->post_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy bài viết';
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
        $pathAvatar = config('my.path.image_post_avatar_of_module');
        $valueAvatar = config('my.image.value.post.avatar');

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $post = $this->postModel::query()->where('post_id', $id)->first();
        if($post){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $post->post_created_by)->first();
            $data['title'] = POST_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['post'] = $post;
            $data['urlAvatar'] = '';

            $data['posts'] = $this->postModel::query()->where([['post_id','!=', $id]])->get();
            $data['arrayRelated'] = !empty($post->post_related) ? explode(',', $post->post_related) : [];

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups'] = $this->postGroupModel::query()->get();

            // Begin Nested items
            $data['parents'] = $this->postGroupModel::where('postgroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $post->post_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy bài viết';
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

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật bài viết thành công.';
        $error   = 'Cập nhật bài viết thất bại.';

        $pathAvatar = config('my.path.image_post_avatar_of_module');
        $valueAvatar = config('my.image.value.post.avatar');
        $pathSave = $this->model.'_m/avatar';

        $params = $this->postModel->revertAlias(request()->post());
        $params['post_slug'] = UrlHelper::postSlug($params['post_name'], $request->slug);
        $params['post_url'] = $params['post_slug'].SUFFIX_URL;
        $params['post_description'] = $params['post_description'] ?? '';
        $params['post_content'] = $params['post_content'] ?? '';

        if($request->related){
            $params['post_related'] = array_diff(array_map('intval', $params['post_related']), [0]);
            $params['post_related'] = implode(",", $params['post_related']);
        }

        try {
            $this->postModel::query()->where('post_id', $id)->update($params);

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

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép bài viết thành công.';
        $error   = 'Sao chép bài viết thất bại.';

        $pathAvatar = config('my.path.image_post_avatar_of_module');
        $valueAvatar = config('my.image.value.post.avatar');
        $pathSave = $this->model.'_m/avatar';

        $params = $this->postModel->revertAlias($request->all());
        $params['post_slug'] = UrlHelper::postSlug($params['post_name'], $request->slug);
        $params['post_url'] = $params['post_slug'].SUFFIX_URL;

        unset($params['post_id']);

        if($request->related){
            $params['post_related'] = array_diff(array_map('intval', $params['post_related']), [0]);
            $params['post_related'] = implode(",", $params['post_related']);
        }

        try {
            $postId = 0;
            $post = $this->postModel::query()->create($params);
            if($post){
                $postId = $post->post_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $postId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $postId;
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
        $success = 'Xóa bài viết thành công.';
        $error   = 'Xóa bài viết thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->postModel->query()->whereIn('post_id', $ids)->update(['post_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->postModel->query(false)->whereIn('post_id', $ids)->update(['post_deleted_by' => $adminId]);
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
        $success = 'Bật bài viết thành công.';
        $error   = 'Bật bài viết thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->postModel->query()->whereIn('post_id', $ids)->update(['post_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->postModel->query()->whereIn('post_id', $ids)->update(['post_updated_by' => $adminId]);
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
        $success = 'Tắt bài viết thành công.';
        $error   = 'Tắt bài viết thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->postModel->query()->whereIn('post_id', $ids)->update(['post_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->postModel->query()->whereIn('post_id', $ids)->update(['post_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
