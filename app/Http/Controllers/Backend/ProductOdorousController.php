<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductOdorousRequest;
use App\Models\ProductOdorous;
use App\Models\AdminUser;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductOdorousController extends BaseController
{
    private $view = '.productodorous';
    private $model = 'productodorous';
    private $productOdorousModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->productOdorousModel = new ProductOdorous();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Quản lý mùi hương';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $odorous = $this->productOdorousModel::query()->get();
        $data['odorous'] = $odorous;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data['title'] = 'Quản lý mùi hương: [Thêm]';
        $data['view']  = $this->viewPath . $this->view . '.add';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductOdorousRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới  mùi hương thành công.';
        $error   = 'Thêm mới  mùi hương thất bại.';
        $params = $this->productOdorousModel->revertAlias($request->all());

        try {
            $this->productOdorousModel::query()->create($params);
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
        $ids = request()->post('cid', []);
        $id = isset($ids[0]) ? $ids[0] : 0;

        $odorous = $this->productOdorousModel::query()->where('podo_id', $id)->first();
        if($odorous){
            $data['title'] = 'Quản lý mùi hương: [Sao Chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['odorous'] = $odorous;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy  mùi hương';
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
        $odorous = $this->productOdorousModel::query()->where('podo_id', $id)->first();
        if($odorous){
            $data['title'] = 'Quản lý mùi hương: [Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['odorous'] = $odorous;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy  mùi hương';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ProductOdorousRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductOdorousRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật  mùi hương thành công.';
        $error   = 'Cập nhật  mùi hương thất bại.';
        $params = $this->productOdorousModel->revertAlias($request->all());

        try {
            $this->productOdorousModel::query()->where('podo_id', $id)->update($params);

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
    public function duplicate(ProductOdorousRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép  mùi hương thành công.';
        $error   = 'Sao chép  mùi hương thất bại.';

        $params = $this->productOdorousModel->revertAlias($request->all());
        unset($params['podo_id']);

        try {
            $this->productOdorousModel::query()->create($params);
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
        $success = 'Xóa  mùi hương thành công.';
        $error   = 'Xóa  mùi hương thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productOdorousModel->query()->whereIn('podo_id', $ids)->update(['podo_is_delete' => 'yes']);
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
        $ids = request()->post('cid', []);
        $success = 'Bật mùi hương thành công.';
        $error   = 'Bật mùi hương thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productOdorousModel->query()->whereIn('podo_id', $ids)->update(['podo_status' => 'activated']);
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
        $ids = request()->post('cid', []);
        $success = 'Tắt  mùi hương thành công.';
        $error   = 'Tắt  mùi hương thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productOdorousModel->query()->whereIn('podo_id', $ids)->update(['podo_status' => 'inactive']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
