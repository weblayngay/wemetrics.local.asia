<?php

namespace App\Http\Controllers\Backend;

use App\Models\Menu;
use App\Models\MenuGroup;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Requests\MenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends BaseController
{
    private $view = '.menu';
    private $model = 'menu';
    private $menuModel;
    private $menuGroupModel;
    public function __construct()
    {
        $this->menuModel = new Menu();
        $this->menuGroupModel = new MenuGroup();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $group = \request()->get('group');
        $data['title'] = MENU_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['group'] = $group;

        $items = $this->menuModel::query()->where('menu_group', $group)->orderBy('menu_sorted', 'asc')->get();
        if($items->count() > 0){
            foreach ($items as $key => $item){
                $group  = $this->menuGroupModel->query()->where('menugroup_id', $item->group_id)->first();
                $item->group = !empty($group) ? $group->menugroup_name : '';
            }
        }
        $data['items'] = $items;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create($parentId = 0)
    {
        $user = Auth::guard('admin')->user();
        $group = \request()->get('group');
        $data['title'] = MENU_TITLE.ADD_LABEL;
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['items'] = $this->menuModel::query()->where('menu_group', $group)->where('menu_parent', 0)->get();
        $data['group'] = $group;
        $data['url'] = '';
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        // Begin Nested items
        $data['parents'] = $this->menuModel::where('menu_parent', null)->with('childItems')->get();
        $data['parentId'] = $parentId;
        // End Nested items
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MenuRequest $request)
    {
        $group = !empty($request->group) ? $request->group : 0;
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model, 'index',['group' => $group]);
        }else{
            $redirect = UrlHelper::admin($this->model,'create', ['group' => $group]);
        }

        $success = 'Đã thêm mới menu items thành công.';
        $error   = 'Thêm mới menu items thất bại.';
        $params = $this->menuModel->revertAlias($request->all());
        if($params['menu_type'] == 'static')
        {
            $params['menu_url'] = UrlHelper::pageUrl($params['menu_name'], $request->menu_url);
        }
        $params['menu_group'] = $group;

        try {
            $item = $this->menuModel::query()->create($params);

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create', ['group' => $group]);
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
        $group = \request()->get('group');

        $item = $this->menuModel::query()->where('menu_id', $id)->first();
        if($item){
            $data['title'] = MENU_TITLE.COPY_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['item'] = $item;
            $data['items'] = $this->menuModel::query()->where('menu_group', $group)->get();
            $data['group'] = $group;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->menuModel::where('menu_parent', null)->with('childItems')->get();
            $data['parentId'] = $item->menu_parent;
            // End Nested items

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy menu items';
            $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }


    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $user = Auth::guard('admin')->user();
        $group = \request()->get('group');
        $id = (int) request()->get('id', 0);
        $item = $this->menuModel::query()->where('menu_id', $id)->first();
        if($item){
            $data['title'] = MENU_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['item'] = $item;
            $data['items'] = $this->menuModel::query()->where('menu_group', $group)
                                                      ->where('menu_id', '<>', $id)
                                                      ->where('menu_parent', 0)
                                                      ->get();
            $data['group'] = $group;
            $data['current_menu_id'] = $id;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            // Begin Nested items
            $data['parents'] = $this->menuModel::where('menu_parent', null)->with('childItems')->get();
            $data['parentId'] = $item->menu_parent;
            // End Nested items

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy menu items';
            $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MenuRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        $group = !empty($request->group) ? $request->group : 0;

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id, 'group' => $group]);
        }

        $success = 'Cập nhật menu items thành công.';
        $error   = 'Cập nhật menu items thất bại.';

        $params = $this->menuModel->revertAlias(request()->post());
        if($params['menu_type'] == 'static')
        {
            $params['menu_url'] = UrlHelper::pageUrl($params['menu_name'], $request->menu_url);
        }
        if(empty($params['menu_parent']))
        {
            $params['menu_parent'] = null;
        }

        $params['menu_group'] = $group;

        try {
            if ($params['menu_parent'] > 0) {
                $menuChilds = $this->menuModel::parentQuery()->where('menu_parent', $id)->get();
                if (count($menuChilds)) {
                    foreach ($menuChilds as $menuChild) {
                        $menuChild->update(['menu_parent' => $params['menu_parent']]);
                    }
                }
            }
            $this->menuModel::query()->where('menu_id', $id)->update($params);
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(MenuRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        $group = !empty($request->group) ? $request->group : 0;

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id, 'group' => $group]);
        }

        $success = 'Sao chép menu items thành công.';
        $error   = 'Sao chép menu items thất bại.';

        $params = $this->menuModel->revertAlias($request->all());
        if($params['menu_type'] == 'static')
        {
            $params['menu_url'] = UrlHelper::pageUrl($params['menu_name'], $request->menu_url);
        }
        $params['menu_group'] = $group;
        unset($params['menu_id']);

        try {
            $item = $this->menuModel::query()->create($params);

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $group = !empty($request->group) ? $request->group : 0;
        $ids = request()->post('cid', []);
        $success = 'Xóa menu items thành công.';
        $error   = 'Xóa menu items thất bại.';

        $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
        $number = $this->menuModel->query()->whereIn('menu_id', $ids)->update(['menu_is_delete' => 'yes']);
        if($number > 0) {
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
        $group = !empty($request->group) ? $request->group : 0;
        $ids = request()->post('cid', []);
        $success = 'Bật menu items thành công.';
        $error   = 'Bật menu items thất bại.';

        $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
        $number = $this->menuModel->query()->whereIn('menu_id', $ids)->update(['menu_status' => 'activated']);
        if($number > 0) {
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
        $group = !empty($request->group) ? $request->group : 0;
        $ids = request()->post('cid', []);
        $success = 'Tắt menu items thành công.';
        $error   = 'Tắt menu items thất bại.';

        $redirect = UrlHelper::admin($this->model, 'index', ['group' => $group]);
        $number = $this->menuModel->query()->whereIn('menu_id', $ids)->update(['menu_status' => 'inactive']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sort(Request $request)
    {
        $ids     = request()->post('cid', []);
        $sorts   = request()->post('sort', []);
        $redirect = UrlHelper::admin($this->model, 'index');

        if (!is_array($ids) || count($ids) == 0) {
            return redirect()->to($redirect)->with('error', 'Vui lòng chọn giá trị để sắp xếp');
        }

        foreach ($ids as $key => $id) {
            $this->bannerModel::parentQuery()->where('menu_id', $id)->update(['menu_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp menu thành công');
    }
}
