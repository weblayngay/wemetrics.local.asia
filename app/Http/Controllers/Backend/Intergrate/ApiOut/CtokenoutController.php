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
use App\Http\Requests\ApiOut\CTokenOutRequest;
use App\Helpers\CryptHelper;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\ApiOut\CTokenVendor;
use App\Models\ApiOut\CTokenOut;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class CtokenoutController extends BaseController
{
    private $view = '.ctokenout';
    private $model = 'ctokenout';
    private $ctokenoutModel;
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    public function __construct()
    {
        $this->ctokenoutModel = new CTokenOut();
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
        $data['title'] = CTOKENOUT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('ctokenout');
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CTOKENOUT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $valueAvatar = config('my.image.value.ctokenout.avatar');

        $tokens = $this->ctokenoutModel::query()->paginate(PAGINATE_PERPAGE);
        $data['tokens'] = $tokens;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CTOKENOUT_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        $data['vendors']  = $this->ctokenvendorModel::query()->select('vendor_id','vendor_name')->where('vendor_status', 'activated')->get();

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CTokenOutRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới khóa kết nối thành công.';
        $error   = 'Thêm mới khóa kết nối thất bại.';

        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $valueAvatar = config('my.image.value.ctokenout.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->ctokenoutModel->revertAlias($request->all());

        try {
            $tokenId = 0;
            $token = $this->ctokenoutModel::query()->create($params);
            if($token){
                $tokenId = $token->ctokenout_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $tokenId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $valueAvatar = config('my.image.value.ctokenout.avatar');

        $token = $this->ctokenoutModel::query()->where('ctokenout_id', $id)->first();
        if($token){
            $data['title'] = CTOKENOUT_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['token'] = $token;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            $data['vendors']  = $this->ctokenvendorModel::query()->select('vendor_id','vendor_name')->where('vendor_status', 'activated')->get();

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy khóa kết nối';
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
        $token = $this->ctokenoutModel::query()->where('ctokenout_id', $id)->first();
        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $valueAvatar = config('my.image.value.ctokenout.avatar');
        $pathSave = $this->model.'_m';

        if($token){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $token->ctokenout_created_by)->first();
            $data['title'] = CTOKENOUT_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['token'] = $token;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            $data['vendors']  = $this->ctokenvendorModel::query()->select('vendor_id','vendor_name')->where('vendor_status', 'activated')->get();

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy khóa kết nối';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param CTokenOutRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CTokenOutRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật khóa kết nối thành công.';
        $error   = 'Cập nhật khóa kết nối thất bại.';

        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $valueAvatar = config('my.image.value.ctokenout.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->ctokenoutModel->revertAlias(request()->post());
        $params['vendor_description'] = $params['vendor_description'] ?? '';

        try {
            $this->ctokenoutModel::query()->where('ctokenout_id', $id)->update($params);

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
    public function duplicate(CTokenOutRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép khóa kết nối thành công.';
        $error   = 'Sao chép khóa kết nối thất bại.';

        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.ctokenout.avatar');

        $params = $this->ctokenoutModel->revertAlias($request->all());

        unset($params['ctokenout_id']);

        try {
            $tokenId = 0;
            $token = $this->ctokenoutModel::query()->create($params);
            if($token){
                $tokenId = $token->ctokenout_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $tokenId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $tokenId;
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
        $success = 'Xóa khóa kết nối thành công.';
        $error   = 'Xóa khóa kết nối thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $tokens = $this->ctokenoutModel->query()->whereIn('ctokenout_id', $ids)->get();
        $number = $this->ctokenoutModel->query()->whereIn('ctokenout_id', $ids)->update(['ctokenout_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->ctokenoutModel->query(false)->whereIn('ctokenout_id', $ids)->update(['ctokenout_deleted_by' => $adminId]);
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
        $success = 'Bật khóa kết nối thành công.';
        $error   = 'Bật khóa kết nối thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->ctokenoutModel->query()->whereIn('ctokenout_id', $ids)->update(['ctokenout_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->ctokenoutModel->query()->whereIn('ctokenout_id', $ids)->update(['ctokenout_updated_by' => $adminId]);
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
        $success = 'Tắt khóa kết nối thành công.';
        $error   = 'Tắt khóa kết nối thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->ctokenoutModel->query()->whereIn('ctokenout_id', $ids)->update(['ctokenout_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->ctokenoutModel->query()->whereIn('ctokenout_id', $ids)->update(['ctokenout_updated_by' => $adminId]);
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
        $columnArr = ['ctokenout_name'];
        foreach($columnArr as $key => $column)
        {
            $ctokenout = $this->ctokenoutModel::search($column, $searchStr, $status, $paginateNum);
            if(!empty($ctokenout) && $ctokenout->total() > 0)
            {
                return $ctokenout;
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

        $data['title'] = CTOKENOUT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $pathAvatar = config('my.path.image_ctokenout_of_module');
        $valueAvatar = config('my.image.value.ctokenout.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $tokens = $this->searchQuery($searchStr, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['tokens'] = $tokens;
        return view($data['view'] , compact('data'));
    }
}