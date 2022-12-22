<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\AdvertRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\Advert;
use App\Models\AdvertGroup;


class AdvertController extends BaseController
{
    private $view = '.advert';
    private $model = 'advert';
    private $advertModel;
    private $advertGroupModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->advertModel = new Advert();
        $this->advertGroupModel = new AdvertGroup();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = ADVERT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_advert_of_module');
        $valueAvatar = config('my.image.value.advert.avatar');

        $adverts = $this->advertModel::query()->get();
        if($adverts->count() > 0){
            foreach ($adverts as $key => $item){
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
                $group = $this->advertGroupModel->query()->where('adgroup_id', $item->group_id)->first();
                $item->groupName = !empty($group->adgroup_name) ? $group->adgroup_name : '';
            }
        }
        $data['adverts'] = $adverts;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = ADVERT_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['groups']  = $this->advertGroupModel::query()->select('adgroup_id','adgroup_name')->where('adgroup_status', 'activated')->get();

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
    public function store(AdvertRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới quảng cáo thành công.';
        $error   = 'Thêm mới quảng cáo thất bại.';

        $pathAvatar = config('my.path.image_advert_of_module');
        $valueAvatar = config('my.image.value.advert.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->advertModel->revertAlias($request->all());
        $params['advert_slug'] = UrlHelper::postSlug($params['advert_name'], $request->slug);
        $params['advert_url'] = $params['advert_slug'].SUFFIX_URL;

        try {
            $advertId = 0;
            $advert = $this->advertModel::query()->create($params);
            if($advert){
                $advertId = $advert->advert_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $advertId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_advert_of_module');
        $valueAvatar = config('my.image.value.advert.avatar');

        $advert = $this->advertModel::query()->where('advert_id', $id)->first();
        if($advert){
            $data['title'] = ADVERT_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['advert'] = $advert;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups']  = $this->advertGroupModel::query()->select('adgroup_id','adgroup_name')->where('adgroup_status', 'activated')->get();

            // Begin Nested items
            $data['parents'] = $this->advertGroupModel::where('adgroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $advert->advert_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy quảng cáo';
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
        $pathAvatar = config('my.path.image_advert_of_module');
        $valueAvatar = config('my.image.value.advert.avatar');
        $pathSave = $this->model.'_m';

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $advert = $this->advertModel::query()->where('advert_id', $id)->first();

        if($advert){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $advert->advert_created_by)->first();
            $data['title'] = ADVERT_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['advert'] = $advert;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups']  = $this->advertGroupModel::query()->select('adgroup_id','adgroup_name')->where('adgroup_status', 'activated')->get();

            // Begin Nested items
            $data['parents'] = $this->advertGroupModel::where('adgroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $advert->advert_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy quảng cáo';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param AdvertRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdvertRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật quảng cáo thành công.';
        $error   = 'Cập nhật quảng cáo thất bại.';

        $pathAvatar = config('my.path.image_advert_of_module');
        $valueAvatar = config('my.image.value.advert.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->advertModel->revertAlias(request()->post());
        $params['advert_slug'] = UrlHelper::postSlug($params['advert_name'], $request->slug);
        $params['advert_url'] = $params['advert_slug'].SUFFIX_URL;
        $params['advert_title'] = $params['advert_title'] ?? '';
        $params['advert_subtitle'] = $params['advert_subtitle'] ?? '';
        $params['advert_description'] = $params['advert_description'] ?? '';
        $params['advert_email_subject'] = $params['advert_email_subject'] ?? '';
        $params['advert_email_content'] = $params['advert_email_content'] ?? '';

        try {
            $this->advertModel::query()->where('advert_id', $id)->update($params);

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
    public function duplicate(AdvertRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép quảng cáo thành công.';
        $error   = 'Sao chép quảng cáo thất bại.';

        $pathAvatar = config('my.path.image_advert_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.advert.avatar');

        $params = $this->advertModel->revertAlias($request->all());
        $params['advert_slug'] = UrlHelper::postSlug($params['advert_name'], $request->slug);
        $params['advert_url'] = $params['advert_slug'].SUFFIX_URL;
        unset($params['advert_id']);

        try {
            $advertId = 0;
            $advert = $this->advertModel::query()->create($params);
            if($advert){
                $advertId = $advert->advert_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $advertId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $advertId;
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
        $success = 'Xóa quảng cáo thành công.';
        $error   = 'Xóa quảng cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->advertModel->query()->whereIn('advert_id', $ids)->update(['advert_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->advertModel->query(false)->whereIn('advert_id', $ids)->update(['advert_deleted_by' => $adminId]);
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
        $success = 'Bật quảng cáo thành công.';
        $error   = 'Bật quảng cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->advertModel->query()->whereIn('advert_id', $ids)->update(['advert_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->advertModel->query()->whereIn('advert_id', $ids)->update(['advert_updated_by' => $adminId]);
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
        $success = 'Tắt quảng cáo thành công.';
        $error   = 'Tắt quảng cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->advertModel->query()->whereIn('advert_id', $ids)->update(['advert_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->advertModel->query()->whereIn('advert_id', $ids)->update(['advert_updated_by' => $adminId]);
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
            $this->advertModel::parentQuery()->where('advert_id', $id)->update(['advert_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp quảng cáo thành công');
    }    
}
