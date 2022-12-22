<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\UrlHelper;
use App\Http\Requests\AdminUserRequest;
use App\Models\AdminGroup;
use App\Models\AdminMenu;
use App\Models\AdminUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class AdminuserController extends BaseController
{

    /**
     * @var AdminUser
     */
    private AdminUser $adminUserModel;

    /**
     * @var AdminGroup
     */
    private AdminGroup $adminGroupModel;

    private $view = 'adminuser';

    public function __construct(AdminUser $adminUserModel, AdminGroup $adminGroupModel)
    {
        $this->adminUserModel = $adminUserModel;
        $this->adminGroupModel = $adminGroupModel;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['adminUsers'] = $this->adminUserModel::query()
            ->select([ADMIN_USER_TBL. '.*', ADMIN_GROUP_TBL . '.name as group_name'])
            ->join(ADMIN_GROUP_TBL, ADMIN_GROUP_TBL . '.adgroup_id', ADMIN_USER_TBL . '.adgroup_id', 'left')
            ->get();
        $data['title'] = 'Quản lý User trang Admin';
        $data['view']  = $this->viewPath . $this->view . '.index';
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function detail()
    {
        $id = \request()->get('id', null);

        $data['title'] = 'Quản lý thành viên: [Thêm]';
        if ($id != null) {
            $data['title'] = 'Quản lý thành viên: [Sửa]';
            $adminUser = $this->adminUserModel::query()->find($id);
            $data['adminUser'] = $adminUser;
            if (!$adminUser){
                return redirect()
                    ->to(UrlHelper::admin('adminuser', 'index'))
                    ->with('error', 'Thành viên không được tìm thấy');
            }
        }

        $data['adminGroups'] = $this->adminGroupModel::query()->get();
        return view($this->viewPath . $this->view . '.detail' , compact('data'));
    }

    public function save(AdminUserRequest $request)
    {
        $id         = $request->post('id', null);
        $name       = $request->post('name', '');
        $username   = $request->post('username', '');
        $email      = $request->post('email', '');
        $status     = $request->post('status', '');
        $adgroupId  = $request->post('adgroup_id', '');
        $password   = $request->post('password', '');
        $data = [
            'name'      => strip_tags($name),
            'username'  => $username,
            'email'     => $email,
            'status'    => $status,
            'adgroup_id'=> $adgroupId,
            'is_deleted'=> 'no',
            'password'  => Hash::make($password),
        ];
        $message = 'Tạo mới thành viên thành công.';
        if ($id > 0) {
            $message = 'Cập nhật thành viên thành công.';
            $adminUser = $this->adminUserModel::query()->find($id);
            if (!$adminUser) {
                return redirect()
                    ->to(UrlHelper::admin('adminUser', 'index'))
                    ->with('error', 'Thành viên không tìm thấy') ;
            } else {
                if (empty($password) || trim($password) == '') {
                    unset($data['password']);
                }
                unset($data['username']);

                $adminUser->update($data);
            }
        }else{
            unset($data['aduser_id']);
            $newAdminUser = $this->adminUserModel::parentQuery()->create($data);
            $id = $newAdminUser->adgroup_id;
        }

        if ($request->post('action_type') == 'save') {
            return redirect()->to(UrlHelper::admin('adminuser', 'index'))->with('success', $message);
        } else {
            return redirect()->to(UrlHelper::admin('adminuser', 'detail', ['id' => $id]))->with('success', $message) ;
        }
    }

}
