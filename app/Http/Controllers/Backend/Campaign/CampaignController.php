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
use App\Http\Requests\CampaignRequest;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\AdminUser;
use App\Models\Image;
use App\Models\Campaign;
use App\Models\CampaignGroup;
use App\Models\CampaignType;
use App\Models\CampaignResult;


class CampaignController extends BaseController
{
    private $view = '.campaign';
    private $model = 'campaign';
    private $campaignModel;
    private $campaignGroupModel;
    private $campaignTypeModel;
    private $campaignResultModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->campaignModel = new Campaign();
        $this->campaignGroupModel = new CampaignGroup();
        $this->campaignTypeModel = new CampaignType();
        $this->campaignResultModel = new CampaignResult();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CAMPAIGN_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_campaign_of_module');
        $valueAvatar = config('my.image.value.campaign.avatar');

        // Begin Nested items
        $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
        $data['parentId'] = 0;
        // End Nested items

        $data['types'] = $this->campaignTypeModel::query()->select('campaigntype_id','campaigntype_name')->IsActivated()->get();

        $campaigns = $this->campaignModel::query()->paginate(PAGINATE_PERPAGE);
        $data['campaigns'] = $campaigns;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CAMPAIGN_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['url'] = '';
        // Begin Nested items
        $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items

        $data['groups']  = $this->campaignGroupModel::query()->select('campaigngroup_id','campaigngroup_name')->where('campaigngroup_status', 'activated')->get();
        $data['types'] = $this->campaignTypeModel::query()->select('campaigntype_id','campaigntype_name')->where('campaigntype_status', 'activate')->get();

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CampaignRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới chiến dịch thành công.';
        $error   = 'Thêm mới chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaign_of_module');
        $valueAvatar = config('my.image.value.campaign.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $params = $this->campaignModel->revertAlias($request->all());
        $params['campaign_slug'] = UrlHelper::campaignSlug($params['campaign_name'], $request->slug);
        $params['campaign_url'] = $params['campaign_slug'].SUFFIX_URL;

        if($request->beganAt)
        {
            $params['campaign_began_at'] = DateHelper::getDate('Y-m-d', $request->beganAt);
        }
        if($request->expiredAt)
        {
            $params['campaign_expired_at'] = DateHelper::getDate('Y-m-d', $request->expiredAt);
        }

        try {
            $campaignId = 0;
            $campaign = $this->campaignModel::query()->create($params);
            if($campaign){
                $campaignId = $campaign->campaign_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $campaignId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_campaign_of_module');
        $valueAvatar = config('my.image.value.campaign.avatar');

        $campaign = $this->campaignModel::query()->where('campaign_id', $id)->first();
        if($campaign){
            $data['title'] = CAMPAIGN_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['campaign'] = $campaign;
            $data['urlAvatar'] = '';
            $data['groups']  = $this->campaignGroupModel::query()->select('campaigngroup_id','campaigngroup_name')->where('campaigngroup_status', 'activated')->get();
            $data['types']  = $this->campaignTypeModel::query()->select('campaigntype_id','campaigntype_name')->where('campaigntype_status', 'activated')->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            // Begin Nested items
            $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $campaign->campaign_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy chiến dịch';
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
        $campaign = $this->campaignModel::query()->where('campaign_id', $id)->first();
        $pathAvatar = config('my.path.image_campaign_of_module');
        $valueAvatar = config('my.image.value.campaign.avatar');
        $pathSave = $this->model.'_m';

        if($campaign){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $campaign->campaign_created_by)->first();
            $data['title'] = CAMPAIGN_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['campaign'] = $campaign;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $data['groups']  = $this->campaignGroupModel::query()->select('campaigngroup_id','campaigngroup_name')->where('campaigngroup_status', 'activated')->get();
            $data['types']  = $this->campaignTypeModel::query()->select('campaigntype_id','campaigntype_name')->where('campaigntype_status', 'activated')->get();

            // Begin Nested items
            $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
            $data['parentId'] = $campaign->campaign_group;
            // End Nested items

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy chiến dịch';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param CampaignRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CampaignRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật chiến dịch thành công.';
        $error   = 'Cập nhật chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaign_of_module');
        $valueAvatar = config('my.image.value.campaign.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->campaignModel->revertAlias(request()->post());
        $params['campaign_slug'] = UrlHelper::campaignSlug($params['campaign_name'], $request->slug);
        $params['campaign_url'] = $params['campaign_slug'].SUFFIX_URL;
        $params['campaign_description'] = $params['campaign_description'] ?? '';

        if($request->beganAt)
        {
            $params['campaign_began_at'] = DateHelper::getDate('Y-m-d', $request->beganAt);
        }
        if($request->expiredAt)
        {
            $params['campaign_expired_at'] = DateHelper::getDate('Y-m-d', $request->expiredAt);
        }

        try {
            $this->campaignModel::query()->where('campaign_id', $id)->update($params);

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
    public function duplicate(CampaignRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép chiến dịch thành công.';
        $error   = 'Sao chép chiến dịch thất bại.';

        $pathAvatar = config('my.path.image_campaign_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.campaign.avatar');

        $params = $this->campaignModel->revertAlias($request->all());
        $params['campaign_slug'] = UrlHelper::campaignSlug($params['campaign_name'], $request->slug);
        $params['campaign_url'] = $params['campaign_slug'].SUFFIX_URL;

        if($request->beganAt)
        {
            $params['campaign_began_at'] = DateHelper::getDate('Y-m-d', $request->beganAt);
        }
        if($request->expiredAt)
        {
            $params['campaign_expired_at'] = DateHelper::getDate('Y-m-d', $request->expiredAt);
        }
        unset($params['campaign_id']);

        try {
            $campaignId = 0;
            $campaign = $this->campaignModel::query()->create($params);
            if($campaign){
                $campaignId = $campaign->campaign_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $campaignId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $campaignId;
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
        $success = 'Xóa chiến dịch thành công.';
        $error   = 'Xóa chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $campaigns = $this->campaignModel->query()->whereIn('campaign_id', $ids)->get();
        foreach($campaigns as $key => $item)
        {
            if(!empty($item->campaign_is_used) && $item->campaign_is_used != null)
            {
                return redirect()->to($redirect)->with('error', $error.' Tồn tại chiến dịch đã được sử dụng');
            }
        }
        $number = $this->campaignModel->query()->whereIn('campaign_id', $ids)->update(['campaign_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignModel->query(false)->whereIn('campaign_id', $ids)->update(['campaign_deleted_by' => $adminId]);
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
        $success = 'Bật chiến dịch thành công.';
        $error   = 'Bật chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->campaignModel->query()->whereIn('campaign_id', $ids)->update(['campaign_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignModel->query()->whereIn('campaign_id', $ids)->update(['campaign_updated_by' => $adminId]);
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
        $success = 'Tắt chiến dịch thành công.';
        $error   = 'Tắt chiến dịch thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->campaignModel->query()->whereIn('campaign_id', $ids)->update(['campaign_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->campaignModel->query()->whereIn('campaign_id', $ids)->update(['campaign_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $group, string $type, string $isUsed, string $status, int $paginateNum)
    {
        $columnArr = ['campaign_slug', 'campaign_name', 'campaign_description'];
        foreach($columnArr as $key => $column)
        {
            $campaigns = $this->campaignModel::search($column, $searchStr, $group, $type, $isUsed, $status, $paginateNum);
            if(!empty($campaigns) && $campaigns->total() > 0)
            {
                return $campaigns;
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
        $type = (string) strip_tags(request()->post('type', ''));
        $isUsed = (string) strip_tags(request()->post('isUsed', ''));
        $status = (string) strip_tags(request()->post('status', ''));

        $data['title'] = CAMPAIGN_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        // Begin Nested items
        $data['parents'] = $this->campaignGroupModel::where('campaigngroup_parent', null)->with('childItems')->get();
        $data['parentId'] = 0;
        // End Nested items
        $data['types']  = $this->campaignTypeModel::query()->select('campaigntype_id','campaigntype_name')->where('campaigntype_status', 'activated')->get();

        $pathAvatar = config('my.path.image_campaign_of_module');
        $valueAvatar = config('my.image.value.campaign.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $campaigns = $this->searchQuery($searchStr, $group, $type, $isUsed, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['campaigns'] = $campaigns;
        return view($data['view'] , compact('data'));
    }
}
