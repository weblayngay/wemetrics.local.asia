<?php

namespace App\Http\Controllers\Backend\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\CampaignTypeRequest;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\AdminUser;
use App\Models\Image;
use App\Models\CampaignType;
use App\Models\Campaign;


class CampaignTypeController extends BaseController
{
    private $view = '.campaigntype';
    private $model = 'campaigntype';
    private $campaignTypeModel;
    private $campaignModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->campaignTypeModel = new CampaignType();
        $this->campaignModel = new Campaign();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CAMPAIGN_TYPE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $valueAvatar = config('my.image.value.campaigntype.avatar');
        $types = $this->campaignTypeModel::query()->paginate(PAGINATE_PERPAGE);
        $data['types'] = $types;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CAMPAIGN_TYPE_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CampaignTypeRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới loại chiến dịch thành công.';
        $error   = 'Thêm mới loại chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $valueAvatar = config('my.image.value.campaigntype.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $params = $this->campaignTypeModel->revertAlias($request->all());

        try {
            $campaignTypeId = 0;
            $campaign = $this->campaignTypeModel::query()->create($params);
            if($campaign){
                $campaignTypeId = $campaign->campaigntype_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $campaignTypeId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $valueAvatar = config('my.image.value.campaigntype.avatar');

        $type = $this->campaignTypeModel::query()->where('campaigntype_id', $id)->first();
        if($type){
            $data['title'] = CAMPAIGN_TYPE_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['type'] = $type;
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
            $error   = 'Không tìm thấy loại chiến dịch';
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
        $type = $this->campaignTypeModel::query()->where('campaigntype_id', $id)->first();
        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $valueAvatar = config('my.image.value.campaigntype.avatar');
        $pathSave = $this->model.'_m';

        if($type){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $type->campaigntype_created_by)->first();
            $data['title'] = CAMPAIGN_TYPE_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['type'] = $type;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy loại chiến dịch';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param CampaignTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CampaignTypeRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật loại chiến dịch thành công.';
        $error   = 'Cập nhật loại chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $valueAvatar = config('my.image.value.campaigntype.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->campaignTypeModel->revertAlias(request()->post());
        $params['campaigntype_description'] = $params['campaigntype_description'] ?? '';

        try {
            $this->campaignTypeModel::query()->where('campaigntype_id', $id)->update($params);

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
    public function duplicate(CampaignTypeRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép loại chiến dịch thành công.';
        $error   = 'Sao chép loại chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.campaigntype.avatar');

        $params = $this->campaignTypeModel->revertAlias($request->all());
        unset($params['campaigntype_id']);

        try {
            $campaignTypeId = 0;
            $campaign = $this->campaignTypeModel::query()->create($params);
            if($campaign){
                $campaignTypeId = $campaign->campaigntype_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $campaignTypeId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $campaignTypeId;
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
        $success = 'Xóa loại chiến dịch thành công.';
        $error   = 'Xóa loại chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $types = $this->campaignTypeModel->query()->whereIn('campaigntype_id', $ids)->get();
        foreach($types as $key => $item)
        {
            if(!empty($item->campaigns) && count($item->campaigns) > 0)
            {
                return redirect()->to($redirect)->with('error', $error.' Tồn tại loại chiến dịch đã được sử dụng');
            }
        }
        $number = $this->campaignTypeModel->query()->whereIn('campaigntype_id', $ids)->update(['campaigntype_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignTypeModel->query(false)->whereIn('campaigntype_id', $ids)->update(['campaigntype_deleted_by' => $adminId]);
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
        $success = 'Bật loại chiến dịch thành công.';
        $error   = 'Bật loại chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->campaignTypeModel->query()->whereIn('campaigntype_id', $ids)->update(['campaigntype_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignTypeModel->query()->whereIn('campaigntype_id', $ids)->update(['campaigntype_updated_by' => $adminId]);
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
        $success = 'Tắt loại chiến dịch thành công.';
        $error   = 'Tắt loại chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->campaignTypeModel->query()->whereIn('campaigntype_id', $ids)->update(['campaigntype_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignTypeModel->query()->whereIn('campaigntype_id', $ids)->update(['campaigntype_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $status, string $isUsed, int $paginateNum)
    {
        $columnArr = ['campaigntype_name', 'campaigntype_description'];
        foreach($columnArr as $key => $column)
        {
            $types = $this->campaignTypeModel::search($column, $searchStr, $status, $isUsed, $paginateNum);
            if(!empty($types) && count($types) > 0)
            {
                return $types;
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
        $isUsed = (string) strip_tags(request()->post('isUsed', ''));
        $status = (string) strip_tags(request()->post('status', ''));

        $data['title'] = CAMPAIGN_TYPE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';
        $data['types']  = $this->campaignTypeModel::query()->select('campaigntype_id','campaigntype_name')->where('campaigntype_status', 'activated')->get();

        $pathAvatar = config('my.path.image_campaigntype_of_module');
        $valueAvatar = config('my.image.value.campaigntype.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $types = $this->searchQuery($searchStr, $status, $isUsed, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['types'] = !empty($types) ? CollectionPaginateHelper::paginate($types, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }
}
