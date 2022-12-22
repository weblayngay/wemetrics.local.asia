<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\BannerRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Models\Image;
use App\Models\Banner;
use App\Models\BannerGroup;


class BannerController extends BaseController
{
    private $view = '.banner';
    private $model = 'banner';
    private $bannerModel;
    private $bannerGroupModel;
    private $imageModel;
    public function __construct()
    {
        $this->bannerModel = new Banner();
        $this->bannerGroupModel = new BannerGroup();
        $this->imageModel = new Image();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = BANNER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_banner_of_module');
        $valueAvatar = config('my.image.value.banner.avatar');

        $banners = $this->bannerModel::query()->orderBy('banner_id', 'desc')->get();
        if($banners->count() > 0){
            foreach ($banners as $key => $item){
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $item->groupName = !empty($item->groups) ? $item->groups->bannergroup_name : '';
            }
        }
        $data['banners'] = $banners;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = BANNER_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['groups']  = $this->bannerGroupModel::query()->select('bannergroup_id','bannergroup_name')->get();

        // Begin Nested items
        $data['parents'] = $this->bannerGroupModel::where('bannergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(BannerRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới banner thành công.';
        $error   = 'Thêm mới banner thất bại.';

        $pathAvatar = config('my.path.image_banner_of_module');
        $valueAvatar = config('my.image.value.banner.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->bannerModel->revertAlias($request->all());
        $params['banner_slug'] = UrlHelper::postSlug($params['banner_name'], $request->slug);
        $params['banner_url'] = $params['banner_slug'].SUFFIX_URL;

        try {
            $bannerId = 0;
            $banner = $this->bannerModel::query()->create($params);
            if($banner){
                $bannerId = $banner->banner_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $bannerId, $valueAvatar, $pathSave);
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
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $pathAvatar = config('my.path.image_banner_of_module');
        $valueAvatar = config('my.image.value.banner.avatar');

        $banner = $this->bannerModel::query()->where('banner_id', $id)->first();
        if($banner){
            $data['title'] = BANNER_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['banner'] = $banner;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups']  = $this->bannerGroupModel::query()->select('bannergroup_id','bannergroup_name')->get();

            // Begin Nested items
            $data['parents'] = $this->bannerGroupModel::where('bannergroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $banner->banner_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy banner';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }


    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit()
    {
        $pathAvatar = config('my.path.image_banner_of_module');
        $valueAvatar = config('my.image.value.banner.avatar');

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $banner = $this->bannerModel::query()->where('banner_id', $id)->first();
        if($banner){
            $data['title'] = BANNER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['banner'] = $banner;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups']  = $this->bannerGroupModel::query()->select('bannergroup_id','bannergroup_name')->get();

            // Begin Nested items
            $data['parents'] = $this->bannerGroupModel::where('bannergroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $banner->banner_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy banner';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param BannerRequest $request
     * @return RedirectResponse
     */
    public function update(BannerRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật banner thành công.';
        $error   = 'Cập nhật banner thất bại.';

        $pathAvatar = config('my.path.image_banner_of_module');
        $valueAvatar = config('my.image.value.banner.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->bannerModel->revertAlias(request()->post());
        $params['banner_slug'] = UrlHelper::postSlug($params['banner_name'], $request->slug);
        $params['banner_url'] = $params['banner_slug'].SUFFIX_URL;

        try {
            $this->bannerModel::query()->where('banner_id', $id)->update($params);
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
            return redirect()->to($redirect)->with('error', $e->getMessage());
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param BannerRequest $request
     * @return RedirectResponse
     */
    public function duplicate(BannerRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép banner thành công.';
        $error   = 'Sao chép banner thất bại.';

        $pathAvatar = config('my.path.image_banner_of_module');
        $valueAvatar = config('my.image.value.banner.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->bannerModel->revertAlias($request->all());
        $params['banner_slug'] = UrlHelper::postSlug($params['banner_name'], $request->slug);
        $params['banner_url'] = $params['banner_slug'].SUFFIX_URL;
        unset($params['banner_id']);

        try {
            $bannerId = 0;
            $banner = $this->bannerModel::query()->create($params);
            if($banner){
                $bannerId = $banner->banner_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $bannerId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $bannerId;
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
     * @return RedirectResponse
     */
    public function delete(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Xóa banner thành công.';
        $error   = 'Xóa banner thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->bannerModel->query()->whereIn('banner_id', $ids)->update(['banner_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->bannerModel->query(false)->whereIn('banner_id', $ids)->update(['banner_deleted_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function active(Request $request): RedirectResponse
    {
        $ids = request()->post('cid', []);
        $success = 'Bật banner thành công.';
        $error   = 'Bật banner thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->bannerModel->query()->whereIn('banner_id', $ids)->update(['banner_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->bannerModel->query()->whereIn('banner_id', $ids)->update(['banner_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function inactive(Request $request): RedirectResponse
    {
        $ids = request()->post('cid', []);
        $success = 'Tắt banner thành công.';
        $error   = 'Tắt banner thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->bannerModel->query()->whereIn('banner_id', $ids)->update(['banner_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->bannerModel->query()->whereIn('banner_id', $ids)->update(['banner_updated_by' => $adminId]);
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
            $this->bannerModel::parentQuery()->where('banner_id', $id)->update(['banner_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp banner thành công');
    }
}
