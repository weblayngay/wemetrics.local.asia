<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerRequest;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\Producer;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProducerController extends BaseController
{
    private $view = '.producer';
    private $model = 'producer';
    private $producerModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->producerModel = new Producer();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = PRODUCER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_producer_of_module');
        $valueAvatar = config('my.image.value.producer.avatar');

        $producers = $this->producerModel::query()->get();
        if($producers->count() > 0){
            foreach ($producers as $key => $item){
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
            }
        }
        $data['producers'] = $producers;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = PRODUCER_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['producers'] = $this->producerModel::query()->get();

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProducerRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới nhà sản xuất thành công.';
        $error   = 'Thêm mới nhà sản xuất thất bại.';

        $pathAvatar = config('my.path.image_producer_of_module');
        $valueAvatar = config('my.image.value.producer.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->producerModel->revertAlias($request->all());
        $params['producer_slug'] = UrlHelper::slug($params['producer_name'], $request->producer_slug);

        try {
            $producerId = 0;
            $producer = $this->producerModel::query()->create($params);
            if($producer){
                $producerId = $producer->producer_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $producerId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_producer_of_module');
        $valueAvatar = config('my.image.value.producer.avatar');

        $producer = $this->producerModel::query()->where('producer_id', $id)->first();
        if($producer){
            $data['title'] = PRODUCER_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['producer'] = $producer;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar.$imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhà sản xuất';
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
        $pathAvatar = config('my.path.image_producer_of_module');
        $valueAvatar = config('my.image.value.producer.avatar');
        $pathSave = $this->model.'_m';

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $producer = $this->producerModel::query()->where('producer_id', $id)->first();

        if($producer){
            $data['title'] = PRODUCER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['producer'] = $producer;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhà sản xuất';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ProducerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProducerRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật nhà sản xuất thành công.';
        $error   = 'Cập nhật nhà sản xuất thất bại.';

        $pathAvatar = config('my.path.image_producer_of_module');
        $valueAvatar = config('my.image.value.producer.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->producerModel->revertAlias(request()->post());
        $params['producer_slug'] = UrlHelper::slug($params['producer_slug'], $request->producer_slug);

        try {
            $this->producerModel::query()->where('producer_id', $id)->update($params);

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
    public function duplicate(ProducerRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép nhà sản xuất thành công.';
        $error   = 'Sao chép nhà sản xuất thất bại.';

        $pathAvatar = config('my.path.image_producer_of_module');
        $valueAvatar = config('my.image.value.producer.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->producerModel->revertAlias($request->all());
        $params['producer_slug'] = UrlHelper::slug($params['producer_slug'], $request->producer_slug);

        unset($params['producer_id']);

        try {
            $producerId = 0;
            $producer = $this->producerModel::query()->create($params);
            if($producer){
                $producerId = $producer->producer_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $producerId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $producerId;
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
        $success = 'Xóa nhà sản xuất thành công.';
        $error   = 'Xóa nhà sản xuất thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->producerModel->query()->whereIn('producer_id', $ids)->update(['producer_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->producerModel->query(false)->whereIn('producer_id', $ids)->update(['producer_deleted_by' => $adminId]);
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
        $success = 'Bật nhà sản xuất thành công.';
        $error   = 'Bật nhà sản xuất thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->producerModel->query()->whereIn('producer_id', $ids)->update(['producer_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->producerModel->query()->whereIn('producer_id', $ids)->update(['producer_updated_by' => $adminId]);
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
        $success = 'Tắt nhà sản xuất thành công.';
        $error   = 'Tắt nhà sản xuất thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->producerModel->query()->whereIn('producer_id', $ids)->update(['producer_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->producerModel->query()->whereIn('producer_id', $ids)->update(['producer_updated_by' => $adminId]);
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
            $this->producerModel::parentQuery()->where('producer_id', $id)->update(['producer_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp nhà sản xuất thành công');
    } 
}
