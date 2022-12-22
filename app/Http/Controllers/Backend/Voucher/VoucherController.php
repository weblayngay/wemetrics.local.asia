<?php

namespace App\Http\Controllers\Backend\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\VoucherRequest;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\Voucher;
use App\Models\VoucherGroup;
use DB;


class VoucherController extends BaseController
{
    private $view = '.voucher';
    private $model = 'voucher';
    private $voucherModel;
    private $voucherGroupModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->voucherModel = new Voucher();
        $this->voucherGroupModel = new VoucherGroup();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = VOUCHER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');

        // Begin Nested items
        $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = 0;
        // End Nested items

        $vouchers = $this->voucherModel::query()->IsActivated()->limit(QUERY_LIMIT)->get();
        $data['vouchers'] = !empty($vouchers) ? CollectionPaginateHelper::paginate($vouchers, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = VOUCHER_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        // Begin Nested items
        $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items

        $data['groups']  = $this->voucherGroupModel::query()->select('vouchergroup_id','vouchergroup_name')->where('vouchergroup_status', 'activated')->get();
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(VoucherRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới mã giảm giá thành công.';
        $error   = 'Thêm mới mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();

        $params = $this->voucherModel->revertAlias($request->all());

        if($request->beganAt)
        {
            $params['voucher_began_at'] = DateHelper::getDate('Y-m-d', $request->beganAt);
        }
        if($request->expiredAt)
        {
            $params['voucher_expired_at'] = DateHelper::getDate('Y-m-d', $request->expiredAt);
        }
        if($request->url){
            $params['voucher_url'] = Str::slug($request->url);
        }

        try {
            $voucherId = 0;
            $voucher = $this->voucherModel::query()->create($params);
            if($voucher){
                $voucherId = $voucher->voucher_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $voucherId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');

        $voucher = $this->voucherModel::query()->where('voucher_id', $id)->first();
        if($voucher){
            $data['title'] = VOUCHER_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['voucher'] = $voucher;
            $data['urlAvatar'] = '';
            $data['groups']  = $this->voucherGroupModel::query()->select('vouchergroup_id','vouchergroup_name')->where('vouchergroup_status', 'activated')->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            // Begin Nested items
            $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $voucher->voucher_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy mã giảm giá';
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
        $voucher = $this->voucherModel::query()->where('voucher_id', $id)->first();
        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');
        $pathSave = $this->model.'_m';

        if($voucher){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $voucher->voucher_created_by)->first();
            $data['title'] = VOUCHER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['voucher'] = $voucher;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups']  = $this->voucherGroupModel::query()->select('vouchergroup_id','vouchergroup_name')->where('vouchergroup_status', 'activated')->get();

            // Begin Nested items
            $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $voucher->voucher_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy mã giảm giá';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param VoucherRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(VoucherRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật mã giảm giá thành công.';
        $error   = 'Cập nhật mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');
        $pathSave = $this->model.'_m';
        $params = $this->voucherModel->revertAlias(request()->post());

        if($request->beganAt)
        {
            $params['voucher_began_at'] = DateHelper::getDate('Y-m-d', $request->beganAt);
        }
        if($request->expiredAt)
        {
            $params['voucher_expired_at'] = DateHelper::getDate('Y-m-d', $request->expiredAt);
        }
        if($request->url){
            $params['voucher_url'] = Str::slug($request->url);
        }

        try {
            $this->voucherModel::query()->where('voucher_id', $id)->update($params);

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
    public function duplicate(VoucherRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép mã giảm giá thành công.';
        $error   = 'Sao chép mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_voucher_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.voucher.avatar');

        $params = $this->voucherModel->revertAlias($request->all());
        if($request->beganAt)
        {
            $params['voucher_began_at'] = DateHelper::getDate('Y-m-d', $request->beganAt);
        }
        if($request->expiredAt)
        {
            $params['voucher_expired_at'] = DateHelper::getDate('Y-m-d', $request->expiredAt);
        }
        if($request->url){
            $params['voucher_url'] = Str::slug($request->url);
        }
        unset($params['voucher_id']);

        try {
            $voucherId = 0;
            $voucher = $this->voucherModel::query()->create($params);
            if($voucher){
                $voucherId = $voucher->voucher_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $voucherId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $voucherId;
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
        $success = 'Xóa mã giảm giá thành công.';
        $error   = 'Xóa mã giảm giá thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $vouchers = $this->voucherModel->query()->whereIn('voucher_id', $ids)->get();
        foreach($vouchers as $key => $item)
        {
            if(!empty($item->voucher_is_used) && $item->voucher_is_used != null)
            {
                return redirect()->to($redirect)->with('error', $error.' Tồn tại mã giảm giá đã được sử dụng');
            }

            if(!empty($item->voucher_is_assigned))
            {
                return redirect()->to($redirect)->with('error', $error.' Tồn tại mã giảm giá đã được cấp phát');
            }
        }
        $number = $this->voucherModel->query()->whereIn('voucher_id', $ids)->update(['voucher_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->voucherModel->query(false)->whereIn('voucher_id', $ids)->update(['voucher_deleted_by' => $adminId]);
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
        $success = 'Bật mã giảm giá thành công.';
        $error   = 'Bật mã giảm giá thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->voucherModel->query()->whereIn('voucher_id', $ids)->update(['voucher_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->voucherModel->query()->whereIn('voucher_id', $ids)->update(['voucher_updated_by' => $adminId]);
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
        $success = 'Tắt mã giảm giá thành công.';
        $error   = 'Tắt mã giảm giá thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->voucherModel->query()->whereIn('voucher_id', $ids)->update(['voucher_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->voucherModel->query()->whereIn('voucher_id', $ids)->update(['voucher_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $group, string $isUsed, string $isAssigned, string $status, int $paginateNum)
    {
        $columnArr = ['voucher_code', 'voucher_name', 'voucher_description'];
        foreach($columnArr as $key => $column)
        {
            $vouchers = $this->voucherModel::search($column, $searchStr, $group, $isUsed, $isAssigned, $status, $paginateNum);
            if(!empty($vouchers) > 0 && count($vouchers) > 0)
            {
                return $vouchers;
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
        $isUsed = (string) strip_tags(request()->post('isUsed', ''));
        $isAssigned = (string) strip_tags(request()->post('isAssigned', ''));
        $status = (string) strip_tags(request()->post('status', ''));

        $data['title'] = VOUCHER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        // Begin Nested items
        $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = 0;
        // End Nested items

        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $vouchers = $this->searchQuery($searchStr, $group, $isUsed, $isAssigned, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['vouchers'] = !empty($vouchers) ? CollectionPaginateHelper::paginate($vouchers, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function synchro()
    {
        $data['title'] = VOUCHER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $success = 'Đồng bộ mã giảm giá thành công.';
        $error   = 'Đồng bộ mã giảm giá thất bại.';

        $pathAvatar = config('my.path.image_voucher_of_module');
        $valueAvatar = config('my.image.value.voucher.avatar');

        // Begin Nested items
        $data['parents'] = $this->voucherGroupModel::where('vouchergroup_parent', null)->with('childItems')->get();
        $data['parentId'] = 0;
        // End Nested items

        $errorMsg = DB::select('call spUpdattUsedVoucher()');
        $redirect = UrlHelper::admin($this->model);
        if(!empty($errorMsg) && count($errorMsg) > 0) {
            return redirect()->to($redirect)->with('error', $error);
        }else{
            return redirect()->to($redirect)->with('success', $success);
        }
    }
}
