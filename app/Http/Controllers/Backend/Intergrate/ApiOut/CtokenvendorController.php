<?php

namespace App\Http\Controllers\Backend\Intergrate\ApiOut;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\ApiOut\CTokenVendorRequest;
use App\Helpers\CryptHelper;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\ApiOut\CTokenVendor;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class CtokenvendorController extends BaseController
{
    private $view = '.ctokenvendor';
    private $model = 'ctokenvendor';
    private $ctokenvendorModel;
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    public function __construct()
    {
        $this->ctokenvendorModel = new CTokenVendor();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function cpanel()
    {
        $data['title'] = CTOKENVENDOR_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('ctokenvendor');
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CTOKENVENDOR_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');

        $vendors = $this->ctokenvendorModel::query()->paginate(PAGINATE_PERPAGE);
        $data['vendors'] = $vendors;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CTOKENVENDOR_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['clientId'] = CryptHelper::CryptClientId();
        $data['clientKey'] = CryptHelper::CryptClientKey();

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CTokenVendorRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới nhà cung cấp kết nối thành công.';
        $error   = 'Thêm mới nhà cung cấp kết nối thất bại.';

        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->ctokenvendorModel->revertAlias($request->all());

        try {
            $vendorId = 0;
            $vendor = $this->ctokenvendorModel::query()->create($params);
            if($vendor){
                $vendorId = $vendor->ctokenvendor_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $vendorId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');

        $vendor = $this->ctokenvendorModel::query()->where('ctokenvendor_id', $id)->first();
        if($vendor){
            $data['title'] = CTOKENVENDOR_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['vendor'] = $vendor;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['clientId'] = CryptHelper::CryptClientId();
            $data['clientKey'] = CryptHelper::CryptClientKey();

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhà cung cấp kết nối';
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
        $vendor = $this->ctokenvendorModel::query()->where('ctokenvendor_id', $id)->first();
        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');
        $pathSave = $this->model.'_m';

        if($vendor){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $vendor->ctokenvendor_created_by)->first();
            $data['title'] = CTOKENVENDOR_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['vendor'] = $vendor;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy nhà cung cấp kết nối';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param CTokenVendorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CTokenVendorRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật nhà cung cấp kết nối thành công.';
        $error   = 'Cập nhật nhà cung cấp kết nối thất bại.';

        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->ctokenvendorModel->revertAlias(request()->post());

        try {
            $this->ctokenvendorModel::query()->where('ctokenvendor_id', $id)->update($params);

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
    public function duplicate(CTokenVendorRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép nhà cung cấp kết nối thành công.';
        $error   = 'Sao chép nhà cung cấp kết nối thất bại.';

        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');

        $params = $this->ctokenvendorModel->revertAlias($request->all());

        unset($params['ctokenvendor_id']);

        try {
            $vendorId = 0;
            $vendor = $this->ctokenvendorModel::query()->create($params);
            if($vendor){
                $vendorId = $vendor->ctokenvendor_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $vendorId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $vendorId;
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
        $success = 'Xóa nhà cung cấp kết nối thành công.';
        $error   = 'Xóa nhà cung cấp kết nối thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $vendors = $this->ctokenvendorModel->query()->whereIn('ctokenvendor_id', $ids)->get();
        $number = $this->ctokenvendorModel->query()->whereIn('ctokenvendor_id', $ids)->update(['ctokenvendor_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->ctokenvendorModel->query(false)->whereIn('ctokenvendor_id', $ids)->update(['ctokenvendor_deleted_by' => $adminId]);
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
        $success = 'Bật nhà cung cấp kết nối thành công.';
        $error   = 'Bật nhà cung cấp kết nối thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->ctokenvendorModel->query()->whereIn('ctokenvendor_id', $ids)->update(['ctokenvendor_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->ctokenvendorModel->query()->whereIn('ctokenvendor_id', $ids)->update(['ctokenvendor_updated_by' => $adminId]);
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
        $success = 'Tắt nhà cung cấp kết nối thành công.';
        $error   = 'Tắt nhà cung cấp kết nối thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->ctokenvendorModel->query()->whereIn('ctokenvendor_id', $ids)->update(['ctokenvendor_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->ctokenvendorModel->query()->whereIn('ctokenvendor_id', $ids)->update(['ctokenvendor_updated_by' => $adminId]);
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
        $columnArr = ['ctokenvendor_name'];
        foreach($columnArr as $key => $column)
        {
            $ctokenvendor = $this->ctokenvendorModel::search($column, $searchStr, $status, $paginateNum);
            if(!empty($ctokenvendor) && $ctokenvendor->total() > 0)
            {
                return $ctokenvendor;
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

        $data['title'] = CTOKENVENDOR_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $pathAvatar = config('my.path.image_ctokenvendor_of_module');
        $valueAvatar = config('my.image.value.ctokenvendor.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $vendors = $this->searchQuery($searchStr, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['vendors'] = $vendors;
        return view($data['view'] , compact('data'));
    }
}