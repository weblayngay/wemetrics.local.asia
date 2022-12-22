<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    private $view = '.user';
    private $model = 'user';
    private $userModel;
    private $provinceModel;
    private $districtModel;
    private $wardModel;
    public function __construct()
    {
        $this->userModel = new User();
        $this->provinceModel = new Province();
        $this->districtModel = new District();
        $this->wardModel = new Ward();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['title'] = USER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $users = $this->userModel::query()->orderBy('id', 'DESC')->paginate(50);
        $data['users'] = $users;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $data['title'] = USER_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        /** ward , district, province*/
        $data['province'] = $this->provinceModel::query()->get();
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới người dùng thành công.';
        $error   = 'Thêm mới người dùng thất bại.';
        $params = [];
        foreach ($this->userModel::ALIAS as $field => $alias) {
            if (($value = Arr::get(request()->post(), $alias)) !== null) {
                Arr::set($params, $field, $value);
            }
        }
        $params['birthday'] = DateHelper::getDate('Y-m-d', $request->userBirthday);
        $params['password'] = Hash::make($request->post('password'));
        try {
            $userId = 0;
            $user = $this->userModel::query()->create($params);
            if($user){
                $userId = $user->id;
            }
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create');
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $id = (int) request()->get('id', 0);
        $user = $this->userModel::query()->where('id', $id)->first();
        $aduser = Auth::guard('admin')->user();
        if($user){
            $data['title'] = USER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['user'] = $user;
            $data['adminName']  = $aduser->username;
            $data['adminId']  = $aduser->aduser_id;

            /** ward , district, province*/
            $data['province'] = $this->provinceModel::query()->get();

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy người dùng';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }


    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật người dùng thành công.';
        $error   = 'Cập nhật người dùng thất bại.';

        $params = [];
        foreach ($this->userModel::ALIAS as $field => $alias) {
            if (($value = Arr::get(request()->post(), $alias)) !== null) {
                Arr::set($params, $field, $value);
            }
        }
        if(!empty($request->post('userBirthday'))) { $params['birthday'] = DateHelper::getDate('Y-m-d', $request->userBirthday); }
        if(!empty($request->post('password'))) { $params['password'] = Hash::make($request->post('password')); }

        try {
            $this->userModel::query()->where('id', $id)->update($params);

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
        $success = 'Xóa người dùng thành công.';
        $error   = 'Xóa người dùng thất bại.';

        $redirect = UrlHelper::admin($this->model);
        // $number = $this->userModel->query()->whereIn('id', $ids)->delete();
        $number = $this->userModel->query()->whereIn('id', $ids)->update(['is_delete' => 'yes']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->userModel->query(false)->whereIn('id', $ids)->update(['deleted_by' => $adminId]);
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
        $success = 'Bật user thành công.';
        $error   = 'Bật user thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->userModel->query()->whereIn('id', $ids)->update(['status' => 'activated']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->userModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);            
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
        $success = 'Tắt user thành công.';
        $error   = 'Tắt user thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->userModel->query()->whereIn('id', $ids)->update(['status' => 'inactive']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->userModel->query()->whereIn('id', $ids)->update(['updated_by' => $adminId]);             
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     */
    public function getDistrict(Request $request){
        $id = $request->id;
        $data = $this->districtModel::query()->where('province_id', $id)->get();

        $html = '<option value="">Chọn</option>';
        if(!empty($data)){
            foreach ($data as $key => $item){
                $html .= '<option value="' . $item->id . '">'. $item->name . '</option>';
            }
        }

        $response = [
            'html' => $html,
        ];
        return json_encode($response);
    }

    /**
     * @param Request $request
     */
    public function getWard(Request $request){
        $id = $request->id;
        $data = $this->wardModel::query()->where('district_id', $id)->get();

        $html = '<option value="">Chọn</option>';
        if(!empty($data)){
            foreach ($data as $key => $item){
                $html .= '<option value="' . $item->id . '">'. $item->name . '</option>';
            }
        }

        $response = [
            'html' => $html,
        ];
        return json_encode($response);
    }
}
