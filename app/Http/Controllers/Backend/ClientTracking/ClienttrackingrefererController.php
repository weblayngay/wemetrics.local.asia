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
use App\Http\Requests\ClientTracking\ClientTrackingRefererRequest;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\ClientTracking\ClientTrackingReferer;
use App\Models\ClientTracking\ClientTrackingUtmSource;
use App\Models\ClientTracking\ClientTrackingUtmMedium;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class ClienttrackingrefererController extends BaseController
{
    private $view = '.clienttrackingreferer';
    private $model = 'clienttrackingreferer';
    private $clienttrackingrefererModel;
    private $utmsourceModel;
    private $utmmediumModel;
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    public function __construct()
    {
        $this->clienttrackingrefererModel = new ClientTrackingReferer();
        $this->utmsourceModel = new ClientTrackingUtmSource();
        $this->utmmediumModel = new ClientTrackingUtmMedium();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function cpanel()
    {
        $data['title'] = CLIENTTRACKING_TRACKINGREFERER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('clienttrackingreferer');
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CLIENTTRACKING_TRACKINGREFERER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');

        $clienttrackingreferers = $this->clienttrackingrefererModel::query()->paginate(PAGINATE_PERPAGE);
        $data['clienttrackingreferers'] = $clienttrackingreferers;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CLIENTTRACKING_TRACKINGREFERER_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['sources'] = $this->utmsourceModel::query()->select('id','name')->IsActivated()->get();
        $data['mediums'] = $this->utmmediumModel::query()->select('id','name')->IsActivated()->get();

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientTrackingRefererRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới trình duyệt thành công.';
        $error   = 'Thêm mới trình duyệt thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $params = $this->clienttrackingrefererModel->revertAlias($request->all());

        try {
            $clienttrackingrefererId = 0;
            $clienttrackingreferer = $this->clienttrackingrefererModel::query()->create($params);
            if($clienttrackingreferer){
                $clienttrackingrefererId = $clienttrackingreferer->id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $clienttrackingrefererId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');

        $clienttrackingreferer = $this->clienttrackingrefererModel::query()->where('id', $id)->first();
        if($clienttrackingreferer){
            $data['title'] = CLIENTTRACKING_TRACKINGREFERER_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['clienttrackingreferer'] = $clienttrackingreferer;
            $data['urlAvatar'] = '';

            $data['sources'] = $this->utmsourceModel::query()->select('id','name')->IsActivated()->get();
            $data['mediums'] = $this->utmmediumModel::query()->select('id','name')->IsActivated()->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id,'3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy trình duyệt';
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
        $clienttrackingreferer = $this->clienttrackingrefererModel::query()->where('id', $id)->first();
        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');
        $pathSave = $this->model.'_m';

        if($clienttrackingreferer){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $clienttrackingreferer->created_by)->first();
            $data['title'] = CLIENTTRACKING_TRACKINGREFERER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['clienttrackingreferer'] = $clienttrackingreferer;
            $data['urlAvatar'] = '';

            $data['sources'] = $this->utmsourceModel::query()->select('id','name')->IsActivated()->get();
            $data['mediums'] = $this->utmmediumModel::query()->select('id','name')->IsActivated()->get();

            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy trình duyệt';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ClientTrackingRefererRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientTrackingRefererRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật trình duyệt thành công.';
        $error   = 'Cập nhật trình duyệt thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->clienttrackingrefererModel->revertAlias(request()->post());

        try {
            $this->clienttrackingrefererModel::query()->where('id', $id)->update($params);

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
    public function duplicate(ClientTrackingRefererRequest $request)
    {
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép trình duyệt thành công.';
        $error   = 'Sao chép trình duyệt thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');

        $params = $this->clienttrackingrefererModel->revertAlias($request->all());

        unset($params['id']);

        try {
            $clienttrackingrefererId = 0;
            $clienttrackingreferer = $this->clienttrackingrefererModel::query()->create($params);
            if($clienttrackingreferer){
                $clienttrackingrefererId = $clienttrackingreferer->id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $clienttrackingrefererId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $clienttrackingrefererId;
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
        $success = 'Xóa trình duyệt thành công.';
        $error   = 'Xóa trình duyệt thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $clienttrackingreferers = $this->clienttrackingrefererModel->query()->whereIn('id', $ids)->get();
        $number = $this->clienttrackingrefererModel->query()->whereIn('id', $ids)->update(['is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingrefererModel->query(false)->whereIn('id', $ids)->update(['deleted_by' => $adminId]);
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
        $success = 'Bật trình duyệt thành công.';
        $error   = 'Bật trình duyệt thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->clienttrackingrefererModel->query()->whereIn('id', $ids)->update(['status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingrefererModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);
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
        $success = 'Tắt trình duyệt thành công.';
        $error   = 'Tắt trình duyệt thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->clienttrackingrefererModel->query()->whereIn('id', $ids)->update(['status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingrefererModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);
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
        $columnArr = ['referral'];
        foreach($columnArr as $key => $column)
        {
            $clienttrackingreferer = $this->clienttrackingrefererModel::search($column, $searchStr, $status, $paginateNum);
            if(!empty($clienttrackingreferer) && $clienttrackingreferer->total() > 0)
            {
                return $clienttrackingreferer;
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

        $data['title'] = CLIENTTRACKING_TRACKINGREFERER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $pathAvatar = config('my.path.image_clienttrackingreferer_of_module');
        $valueAvatar = config('my.image.value.clienttrackingreferer.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $clienttrackingreferers = $this->searchQuery($searchStr, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['clienttrackingreferers'] = $clienttrackingreferers;
        return view($data['view'] , compact('data'));
    }
}