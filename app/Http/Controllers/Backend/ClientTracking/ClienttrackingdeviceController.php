<?php

namespace App\Http\Controllers\Backend\ClientTracking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\ClientTracking\ClientTrackingDeviceRequest;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\ClientTracking\ClientTrackingDevice;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class ClienttrackingdeviceController extends BaseController
{
    private $view = '.clienttrackingdevice';
    private $model = 'clienttrackingdevice';
    private $clienttrackingdeviceModel;
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    public function __construct()
    {
        $this->clienttrackingdeviceModel = new ClientTrackingDevice();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function cpanel()
    {
        $data['title'] = CLIENTTRACKING_TRACKINGDEVICE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('clienttrackingdevice');
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CLIENTTRACKING_TRACKINGDEVICE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');

        $clienttrackingdevices = $this->clienttrackingdeviceModel::query()->paginate(PAGINATE_PERPAGE);
        $data['clienttrackingdevices'] = $clienttrackingdevices;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CLIENTTRACKING_TRACKINGDEVICE_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientTrackingDeviceRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới thiết bị thành công.';
        $error   = 'Thêm mới thiết bị thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $params = $this->clienttrackingdeviceModel->revertAlias($request->all());

        try {
            $clienttrackingdeviceId = 0;
            $clienttrackingdevice = $this->clienttrackingdeviceModel::query()->create($params);
            if($clienttrackingdevice){
                $clienttrackingdeviceId = $clienttrackingdevice->id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $clienttrackingdeviceId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');

        $clienttrackingdevice = $this->clienttrackingdeviceModel::query()->where('id', $id)->first();
        if($clienttrackingdevice){
            $data['title'] = CLIENTTRACKING_TRACKINGDEVICE_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['clienttrackingdevice'] = $clienttrackingdevice;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy thiết bị';
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
        $clienttrackingdevice = $this->clienttrackingdeviceModel::query()->where('id', $id)->first();
        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');
        $pathSave = $this->model.'_m';

        if($clienttrackingdevice){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $clienttrackingdevice->created_by)->first();
            $data['title'] = CLIENTTRACKING_TRACKINGDEVICE_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['clienttrackingdevice'] = $clienttrackingdevice;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy thiết bị';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ClientTrackingDeviceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientTrackingDeviceRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật thiết bị thành công.';
        $error   = 'Cập nhật thiết bị thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->clienttrackingdeviceModel->revertAlias(request()->post());

        try {
            $this->clienttrackingdeviceModel::query()->where('id', $id)->update($params);

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
    public function duplicate(ClientTrackingDeviceRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép thiết bị thành công.';
        $error   = 'Sao chép thiết bị thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');

        $params = $this->clienttrackingdeviceModel->revertAlias($request->all());

        unset($params['id']);

        try {
            $clienttrackingdeviceId = 0;
            $clienttrackingdevice = $this->clienttrackingdeviceModel::query()->create($params);
            if($clienttrackingdevice){
                $clienttrackingdeviceId = $clienttrackingdevice->id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $clienttrackingdeviceId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $clienttrackingdeviceId;
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
        $success = 'Xóa thiết bị thành công.';
        $error   = 'Xóa thiết bị thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $clienttrackingdevices = $this->clienttrackingdeviceModel->query()->whereIn('id', $ids)->get();
        $number = $this->clienttrackingdeviceModel->query()->whereIn('id', $ids)->update(['is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingdeviceModel->query(false)->whereIn('id', $ids)->update(['deleted_by' => $adminId]);
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
        $success = 'Bật thiết bị thành công.';
        $error   = 'Bật thiết bị thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->clienttrackingdeviceModel->query()->whereIn('id', $ids)->update(['status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingdeviceModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);
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
        $success = 'Tắt thiết bị thành công.';
        $error   = 'Tắt thiết bị thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->clienttrackingdeviceModel->query()->whereIn('id', $ids)->update(['status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingdeviceModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $status, int $paginateNum)
    {
        $columnArr = ['name'];
        foreach($columnArr as $key => $column)
        {
            $clienttrackingdevice = $this->clienttrackingdeviceModel::search($column, $searchStr, $status, $paginateNum);
            if(!empty($clienttrackingdevice) && $clienttrackingdevice->total() > 0)
            {
                return $clienttrackingdevice;
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
        $group = (string) strip_tags(request()->post('group', ''));
        $status = (string) strip_tags(request()->post('status', ''));

        $data['title'] = CLIENTTRACKING_TRACKINGDEVICE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $pathAvatar = config('my.path.image_clienttrackingdevice_of_module');
        $valueAvatar = config('my.image.value.clienttrackingdevice.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $clienttrackingdevices = $this->searchQuery($searchStr, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['clienttrackingdevices'] = $clienttrackingdevices;
        return view($data['view'] , compact('data'));
    }
}