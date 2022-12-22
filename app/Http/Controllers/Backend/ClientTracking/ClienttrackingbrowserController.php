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
use App\Http\Requests\ClientTracking\ClientTrackingBrowserRequest;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Models\ClientTracking\ClientTrackingBrowser;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;

class ClienttrackingbrowserController extends BaseController
{
    private $view = '.clienttrackingbrowser';
    private $model = 'clienttrackingbrowser';
    private $clienttrackingbrowserModel;
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    public function __construct()
    {
        $this->clienttrackingbrowserModel = new ClientTrackingBrowser();
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
    }

    /**
     * @return Application|Factory|View
     */
    public function cpanel()
    {
        $data['title'] = CLIENTTRACKING_TRACKINGBROWSER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.cpanel';
        $data['parentMenus'] = $this->adminMenuModel->getMenuItems('clienttrackingbrowser');
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CLIENTTRACKING_TRACKINGBROWSER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');

        $clienttrackingbrowsers = $this->clienttrackingbrowserModel::query()->paginate(PAGINATE_PERPAGE);
        $data['clienttrackingbrowsers'] = $clienttrackingbrowsers;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = CLIENTTRACKING_TRACKINGBROWSER_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';

        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientTrackingBrowserRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới trình duyệt thành công.';
        $error   = 'Thêm mới trình duyệt thất bại.';

        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');
        $pathSave = $this->model.'_m';

        $user = Auth::guard('admin')->user();
        $params = $this->clienttrackingbrowserModel->revertAlias($request->all());

        try {
            $clienttrackingbrowserId = 0;
            $clienttrackingbrowser = $this->clienttrackingbrowserModel::query()->create($params);
            if($clienttrackingbrowser){
                $clienttrackingbrowserId = $clienttrackingbrowser->id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $clienttrackingbrowserId, $valueAvatar, $pathSave);
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
        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');

        $clienttrackingbrowser = $this->clienttrackingbrowserModel::query()->where('id', $id)->first();
        if($clienttrackingbrowser){
            $data['title'] = CLIENTTRACKING_TRACKINGBROWSER_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['clienttrackingbrowser'] = $clienttrackingbrowser;
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
        $clienttrackingbrowser = $this->clienttrackingbrowserModel::query()->where('id', $id)->first();
        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');
        $pathSave = $this->model.'_m';

        if($clienttrackingbrowser){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $clienttrackingbrowser->created_by)->first();
            $data['title'] = CLIENTTRACKING_TRACKINGBROWSER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['clienttrackingbrowser'] = $clienttrackingbrowser;
            $data['urlAvatar'] = '';

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
     * @param ClientTrackingBrowserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientTrackingBrowserRequest $request)
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

        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');
        $pathSave = $this->model.'_m';

        $params = $this->clienttrackingbrowserModel->revertAlias(request()->post());

        try {
            $this->clienttrackingbrowserModel::query()->where('id', $id)->update($params);

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
    public function duplicate(ClientTrackingBrowserRequest $request)
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

        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $pathSave = $this->model.'_m';
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');

        $params = $this->clienttrackingbrowserModel->revertAlias($request->all());

        unset($params['id']);

        try {
            $clienttrackingbrowserId = 0;
            $clienttrackingbrowser = $this->clienttrackingbrowserModel::query()->create($params);
            if($clienttrackingbrowser){
                $clienttrackingbrowserId = $clienttrackingbrowser->id;
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $clienttrackingbrowserId, $valueAvatar, $pathSave);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $clienttrackingbrowserId;
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
        $clienttrackingbrowsers = $this->clienttrackingbrowserModel->query()->whereIn('id', $ids)->get();
        $number = $this->clienttrackingbrowserModel->query()->whereIn('id', $ids)->update(['is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingbrowserModel->query(false)->whereIn('id', $ids)->update(['deleted_by' => $adminId]);
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
        $number = $this->clienttrackingbrowserModel->query()->whereIn('id', $ids)->update(['status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingbrowserModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);
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
        $number = $this->clienttrackingbrowserModel->query()->whereIn('id', $ids)->update(['status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->clienttrackingbrowserModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);
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
            $clienttrackingbrowser = $this->clienttrackingbrowserModel::search($column, $searchStr, $status, $paginateNum);
            if(!empty($clienttrackingbrowser) && $clienttrackingbrowser->total() > 0)
            {
                return $clienttrackingbrowser;
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

        $data['title'] = CLIENTTRACKING_TRACKINGBROWSER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $pathAvatar = config('my.path.image_clienttrackingbrowser_of_module');
        $valueAvatar = config('my.image.value.clienttrackingbrowser.avatar');
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $clienttrackingbrowsers = $this->searchQuery($searchStr, $status, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['clienttrackingbrowsers'] = $clienttrackingbrowsers;
        return view($data['view'] , compact('data'));
    }
}