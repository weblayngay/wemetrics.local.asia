<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\UrlHelper;
use App\Http\Requests\PerceivedValueRequest;
use App\Models\PerceivedValue;
use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PerceivedvalueController extends BaseController
{
    /**
     * @var PerceivedValue
     */
    private $view = '.perceivedvalue';
    private $model = 'perceivedvalue';
    private $perceivedValueModel;
    private $imageModel;

    /**
     * PerceivedvalueController constructor.
     * @param PerceivedValue $perceivedValueModel
     */
    public function __construct()
    {
        $this->perceivedValueModel = new PerceivedValue();
        $this->imageModel = new Image();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = PERCEIVEDVALUE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_pervalue_of_module');
        $valueAvatar = config('my.image.value.pervalue.avatar');

        $perceivedValues = $this->perceivedValueModel::parentQuery()->orderBy('pervalue_sorted', 'desc')->get();
        if($perceivedValues->count() > 0){
            foreach ($perceivedValues as $key => $item){
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
            }
        }
        $data['perceivedValues'] = $perceivedValues;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = PERCEIVEDVALUE_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(PerceivedValueRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới cảm nghĩ khách hàng thành công.';
        $error   = 'Thêm mới cảm nghĩ khách hàng thất bại.';

        $pathAvatar = config('my.path.image_pervalue_of_module');
        $valueAvatar = config('my.image.value.pervalue.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->perceivedValueModel->revertAlias($request->all());

        try {
            $perceivedValueId = 0;
            $perceivedValue = $this->perceivedValueModel::query()->create($params);
            if($perceivedValue){
                $perceivedValueId = $perceivedValue->pervalue_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $perceivedValueId, $valueAvatar, $pathSave);
            }

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create');
            return redirect()->to($redirect)->with('error', $e->getMessage());
        }
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function copy()
    {
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $pathAvatar = config('my.path.image_pervalue_of_module');
        $valueAvatar = config('my.image.value.pervalue.avatar');

        $perceivedValue = $this->perceivedValueModel::query()->where('pervalue_id', $id)->first();
        if($perceivedValue){
            $data['title'] = PERCEIVEDVALUE_TITLE.ADD_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['perceivedValue'] = $perceivedValue;
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
            $error   = 'Không tìm thấy cảm nghĩ khách hàng';
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
        $pathAvatar = config('my.path.image_pervalue_of_module');
        $valueAvatar = config('my.image.value.pervalue.avatar');

        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $perceivedValue = $this->perceivedValueModel::query()->where('pervalue_id', $id)->first();
        if($perceivedValue){
            $data['title'] = PERCEIVEDVALUE_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['perceivedValue'] = $perceivedValue;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy cảm nghĩ khách hàng';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param PerceivedValueRequest $request
     * @return RedirectResponse
     */
    public function update(PerceivedValueRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật cảm nghĩ khách hàng thành công.';
        $error   = 'Cập nhật cảm nghĩ khách hàng thất bại.';

        $pathAvatar = config('my.path.image_pervalue_of_module');
        $valueAvatar = config('my.image.value.pervalue.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->perceivedValueModel->revertAlias(request()->post());

        try {
            $this->perceivedValueModel::query()->where('pervalue_id', $id)->update($params);
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
    public function duplicate(PerceivedValueRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép cảm nghĩ khách hàng thành công.';
        $error   = 'Sao chép cảm nghĩ khách hàng thất bại.';

        $pathAvatar = config('my.path.image_pervalue_of_module');
        $valueAvatar = config('my.image.value.pervalue.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->perceivedValueModel->revertAlias($request->all());
        
        unset($params['pervalue_id']);

        try {
            $perceivedValueId = 0;
            $perceivedValue = $this->perceivedValueModel::query()->create($params);
            if($perceivedValue){
                $perceivedValueId = $perceivedValue->pervalue_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $perceivedValueId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $perceivedValueId;
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
        $success = 'Xóa cảm nghĩ khách hàng thành công.';
        $error   = 'Xóa cảm nghĩ khách hàng thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->perceivedValueModel->query()->whereIn('pervalue_id', $ids)->update(['pervalue_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->perceivedValueModel->query(false)->whereIn('pervalue_id', $ids)->update(['pervalue_deleted_by' => $adminId]);
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
        $success = 'Bật cảm nghĩ khách hàng thành công.';
        $error   = 'Bật cảm nghĩ khách hàng thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->perceivedValueModel->query()->whereIn('pervalue_id', $ids)->update(['pervalue_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->perceivedValueModel->query()->whereIn('pervalue_id', $ids)->update(['pervalue_updated_by' => $adminId]);
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
        $success = 'Tắt cảm nghĩ khách hàng thành công.';
        $error   = 'Tắt cảm nghĩ khách hàng thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->perceivedValueModel->query()->whereIn('pervalue_id', $ids)->update(['pervalue_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->perceivedValueModel->query()->whereIn('pervalue_id', $ids)->update(['pervalue_updated_by' => $adminId]);
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
            $this->perceivedValueModel::parentQuery()->where('pervalue_id', $id)->update(['pervalue_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp cảm nghĩ khách hàng thành công');
    }
}
