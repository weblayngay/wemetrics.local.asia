<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductNutritionsRequest;
use App\Models\ProductNutritions;
use App\Models\AdminUser;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductNutritionsController extends BaseController
{
    private $view = '.productnutritions';
    private $model = 'productnutritions';
    private $productNutritionsModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->productNutritionsModel = new ProductNutritions();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Quản lý dưỡng chất';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $nutritions = $this->productNutritionsModel::query()->get();
        $data['nutritions'] = $nutritions;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data['title'] = 'Quản lý dưỡng chất: [Thêm]';
        $data['view']  = $this->viewPath . $this->view . '.add';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductNutritionsRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới dưỡng chất thành công.';
        $error   = 'Thêm mới dưỡng chất thất bại.';
        $params = $this->productNutritionsModel->revertAlias($request->all());

        try {
            $this->productNutritionsModel::query()->create($params);
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

        $nutritions = $this->productNutritionsModel::query()->where('pnutri_id', $id)->first();
        if($nutritions){
            $data['title'] = 'Quản lý dưỡng chất: [Sao Chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['nutritions'] = $nutritions;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy dưỡng chất';
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
        $nutritions = $this->productNutritionsModel::query()->where('pnutri_id', $id)->first();
        if($nutritions){
            $data['title'] = 'Quản lý dưỡng chất: [Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['nutritions'] = $nutritions;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy dưỡng chất';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ProductNutritionsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductNutritionsRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật dưỡng chất thành công.';
        $error   = 'Cập nhật dưỡng chất thất bại.';
        $params = $this->productNutritionsModel->revertAlias($request->all());

        try {
            $this->productNutritionsModel::query()->where('pnutri_id', $id)->update($params);

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
    public function duplicate(ProductNutritionsRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép dưỡng chất thành công.';
        $error   = 'Sao chép dưỡng chất thất bại.';

        $params = $this->productNutritionsModel->revertAlias($request->all());
        unset($params['pnutri_id']);

        try {
            $this->productNutritionsModel::query()->create($params);
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
        $success = 'Xóa dưỡng chất thành công.';
        $error   = 'Xóa dưỡng chất thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productNutritionsModel->query()->whereIn('pnutri_id', $ids)->update(['pnutri_is_delete' => 'yes']);
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
        $success = 'Bật dưỡng chất thành công.';
        $error   = 'Bật dưỡng chất thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productNutritionsModel->query()->whereIn('pnutri_id', $ids)->update(['pnutri_status' => 'activated']);
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
        $success = 'Tắt dưỡng chất thành công.';
        $error   = 'Tắt dưỡng chất thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productNutritionsModel->query()->whereIn('pnutri_id', $ids)->update(['pnutri_status' => 'inactive']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
