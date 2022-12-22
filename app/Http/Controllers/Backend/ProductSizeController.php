<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertRequest;
use App\Http\Requests\ProductSizeRequest;
use App\Models\AdminUser;
use App\Models\ProductSize;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductSizeController extends BaseController
{
    private $view = '.productsize';
    private $model = 'productsize';
    private $productSizeModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->productSizeModel = new ProductSize();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Quản lý kích thước';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $sises = $this->productSizeModel::query()->get();
        $data['sizes'] = $sises;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data['title'] = 'Quản lý kích thước[Thêm]';
        $data['view']  = $this->viewPath . $this->view . '.add';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductSizeRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới kích thước thành công.';
        $error   = 'Thêm mới kích thước thất bại.';
        $params = $this->productSizeModel->revertAlias($request->all());

        try {
            $this->productSizeModel::query()->create($params);
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

        $size = $this->productSizeModel::query()->where('psize_id', $id)->first();
        if($size){
            $data['title'] = 'Quản lý kích thước[Sao Chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['size'] = $size;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy kích thước';
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
        $size = $this->productSizeModel::query()->where('psize_id', $id)->first();
        if($size){
            $data['title'] = 'Quản lý kích thước[Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['size'] = $size;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy kích thước';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param AdvertRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductSizeRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật kích thước thành công.';
        $error   = 'Cập nhật kích thước thất bại.';
        $params = $this->productSizeModel->revertAlias(request()->post());

        try {
            $this->productSizeModel::query()->where('psize_id', $id)->update($params);

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
    public function duplicate(ProductSizeRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép kích thước thành công.';
        $error   = 'Sao chép kích thước thất bại.';

        $params = $this->productSizeModel->revertAlias($request->all());
        unset($params['psize_id']);

        try {
            $this->productSizeModel::query()->create($params);
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
        $success = 'Xóa kích thước thành công.';
        $error   = 'Xóa kích thước thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productSizeModel->query()->whereIn('psize_id', $ids)->update(['psize_is_delete' => 'yes']);
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
        $success = 'Bật kích thước thành công.';
        $error   = 'Bật kích thước thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productSizeModel->query()->whereIn('psize_id', $ids)->update(['psize_status' => 'activated']);
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
        $success = 'Tắt kích thước thành công.';
        $error   = 'Tắt kích thước thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productSizeModel->query()->whereIn('psize_id', $ids)->update(['psize_status' => 'inactive']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
