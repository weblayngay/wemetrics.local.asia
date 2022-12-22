<?php

namespace App\Http\Controllers\Backend\Intergrate\FBAds;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\DigitalAds\FBAdsRequest;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\DigitalAds\FBAds;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class FbadsController extends BaseController
{
    private $view = '.fbads';
    private $model = 'fbads';
    private $fbadsModel;
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    public function __construct()
    {
        $this->fbadsModel = new FBAds();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function cpanel()
    {
        $data['title'] = FBADS_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('fbads');
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = FBADS_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_fbads_of_module');
        $valueAvatar = config('my.image.value.fbads.avatar');

        $reports = $this->fbadsModel::query()->paginate(PAGINATE_PERPAGE);
        $data['reports'] = $reports;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = FBADS_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        $data['url'] = '';

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FBAdsRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới báo cáo thành công.';
        $error   = 'Thêm mới báo cáo thất bại.';

        $pathAvatar = config('my.path.image_fbads_of_module');
        $valueAvatar = config('my.image.value.fbads.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $params = $this->fbadsModel->revertAlias($request->all());

        try {
            $reportId = 0;
            $report = $this->fbadsModel::query()->create($params);
            if($report){
                $reportId = $report->report_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $reportId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_fbads_of_module');
        $valueAvatar = config('my.image.value.fbads.avatar');

        $report = $this->fbadsModel::query()->where('report_id', $id)->first();
        if($report){
            $data['title'] = FBADS_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['report'] = $report;
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
            $error   = 'Không tìm thấy báo cáo';
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
        $report = $this->fbadsModel::query()->where('report_id', $id)->first();
        $pathAvatar = config('my.path.image_fbads_of_module');
        $valueAvatar = config('my.image.value.fbads.avatar');
        $pathSave = $this->model.'_m';

        if($report){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $report->report_created_by)->first();
            $data['title'] = FBADS_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['report'] = $report;
            $data['urlAvatar'] = '';

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy báo cáo';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param FBAdsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FBAdsRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật báo cáo thành công.';
        $error   = 'Cập nhật báo cáo thất bại.';

        $pathAvatar = config('my.path.image_fbads_of_module');
        $valueAvatar = config('my.image.value.fbads.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->fbadsModel->revertAlias(request()->post());

        try {
            $this->fbadsModel::query()->where('report_id', $id)->update($params);

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
    public function duplicate(FBAdsRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép báo cáo thành công.';
        $error   = 'Sao chép báo cáo thất bại.';

        $pathAvatar = config('my.path.image_fbads_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.fbads.avatar');

        $params = $this->fbadsModel->revertAlias($request->all());

        unset($params['report_id']);

        try {
            $reportId = 0;
            $report = $this->fbadsModel::query()->create($params);
            if($report){
                $reportId = $report->report_id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $reportId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $reportId;
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
        $success = 'Xóa báo cáo thành công.';
        $error   = 'Xóa báo cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $reports = $this->fbadsModel->query()->whereIn('report_id', $ids)->get();
        $number = $this->fbadsModel->query()->whereIn('report_id', $ids)->update(['report_is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->fbadsModel->query(false)->whereIn('report_id', $ids)->update(['report_deleted_by' => $adminId]);
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
        $success = 'Bật báo cáo thành công.';
        $error   = 'Bật báo cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->fbadsModel->query()->whereIn('report_id', $ids)->update(['report_status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->fbadsModel->query()->whereIn('report_id', $ids)->update(['report_updated_by' => $adminId]);
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
        $success = 'Tắt báo cáo thành công.';
        $error   = 'Tắt báo cáo thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->fbadsModel->query()->whereIn('report_id', $ids)->update(['report_status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->fbadsModel->query()->whereIn('report_id', $ids)->update(['report_updated_by' => $adminId]);
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
        $columnArr = ['report_name'];
        foreach($columnArr as $key => $column)
        {
            $fbads = $this->fbadsModel::search($column, $searchStr, $status, $paginateNum);
            if(!empty($fbads) && $fbads->total() > 0)
            {
                return $fbads;
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

        $data['title'] = FBADS_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $pathAvatar = config('my.path.image_fbads_of_module');
        $valueAvatar = config('my.image.value.fbads.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $reports = $this->searchQuery($searchStr, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['reports'] = $reports;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function report()
    {
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $report = $this->fbadsModel::query()->where('report_id', $id)->first();

        if($report){
            $data['title'] = Str::title($report->report_name);
            $data['view']  = $this->viewPath . $this->view . '.report';

            if(!Empty($report->report_url))
            {
                $url = $report->report_url;
            }
            else
            {
                $url = '';
            }
            $style = 'style="border:0; overflow:scroll; width: 100%; height: 100vh;"';
            $frameborder = 'frameborder="0"';
            $htmlDataStudio = '<iframe src="'.$url.'" '.$frameborder.' '.$style.' allowfullscreen></iframe>';
            $data['htmlDataStudio']  = $htmlDataStudio;
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy báo cáo';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function reportOverview()
    {
        $data['title'] = 'Facebook Ads Overview';
        $data['view']  = $this->viewPath . $this->view . '.report';

        $objReport = $this->fbadsModel::query()->where('report_name', 'fb-ads-overview')->first();
        if(!Empty($objReport->report_url))
        {
            $url = $objReport->report_url;
        }
        else
        {
            $url = '';
        }
        $style = 'style="border:0; overflow:scroll; width: 100%; height: 100vh;"';
        $frameborder = 'frameborder="0"';
        $htmlDataStudio = '<iframe src="'.$url.'" '.$frameborder.' '.$style.' allowfullscreen></iframe>';
        $data['htmlDataStudio']  = $htmlDataStudio;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function reportDevice()
    {
        $data['title'] = 'Facebook Ads Device';
        $data['view']  = $this->viewPath . $this->view . '.report';

        $objReport = $this->fbadsModel::query()->where('report_name', 'fb-ads-device')->first();
        if(!Empty($objReport->report_url))
        {
            $url = $objReport->report_url;
        }
        else
        {
            $url = '';
        }
        $style = 'style="border:0; overflow:scroll; width: 100%; height: 100vh;"';
        $frameborder = 'frameborder="0"';
        $htmlDataStudio = '<iframe src="'.$url.'" '.$frameborder.' '.$style.' allowfullscreen></iframe>';
        $data['htmlDataStudio']  = $htmlDataStudio;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function reportDemographic()
    {
        $data['title'] = 'Facebook Ads Demographic Performance';
        $data['view']  = $this->viewPath . $this->view . '.report';

        $objReport = $this->tiktokadsModel::query()->where('report_name', 'facebook-ads-demographics')->first();
        if(!Empty($objReport->report_url))
        {
            $url = $objReport->report_url;
        }
        else
        {
            $url = '';
        }
        $style = 'style="border:0; overflow:scroll; width: 100%; height: 100vh;"';
        $frameborder = 'frameborder="0"';
        $htmlDataStudio = '<iframe src="'.$url.'" '.$frameborder.' '.$style.' allowfullscreen></iframe>';
        $data['htmlDataStudio']  = $htmlDataStudio;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function reportPerformance()
    {
        $data['title'] = 'Facebook Ads Performance';
        $data['view']  = $this->viewPath . $this->view . '.report';

        $objReport = $this->fbadsModel::query()->where('report_name', 'fb-ads-performance')->first();
        if(!Empty($objReport->report_url))
        {
            $url = $objReport->report_url;
        }
        else
        {
            $url = '';
        }
        $style = 'style="border:0; overflow:scroll; width: 100%; height: 100vh;"';
        $frameborder = 'frameborder="0"';
        $htmlDataStudio = '<iframe src="'.$url.'" '.$frameborder.' '.$style.' allowfullscreen></iframe>';
        $data['htmlDataStudio']  = $htmlDataStudio;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function reportCompare()
    {
        $data['title'] = 'Facebook Ads Compare With Adwords';
        $data['view']  = $this->viewPath . $this->view . '.report';

        $objReport = $this->fbadsModel::query()->where('report_name', 'fb-ads-compare-with-adwords')->first();
        if(!Empty($objReport->report_url))
        {
            $url = $objReport->report_url;
        }
        else
        {
            $url = '';
        }
        $style = 'style="border:0; overflow:scroll; width: 100%; height: 100vh;"';
        $frameborder = 'frameborder="0"';
        $htmlDataStudio = '<iframe src="'.$url.'" '.$frameborder.' '.$style.' allowfullscreen></iframe>';
        $data['htmlDataStudio']  = $htmlDataStudio;
        return view($data['view'] , compact('data'));
    }
}