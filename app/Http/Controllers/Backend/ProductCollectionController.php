<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCollectionRequest;
use App\Models\ProductCollection;
use App\Models\AdminUser;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductCollectionController extends BaseController
{
    private $view = '.productcollection';
    private $model = 'productcollection';
    private $productCollectionModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->productCollectionModel = new ProductCollection();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Quản lý bộ sưu tập';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $collections = $this->productCollectionModel::query()->get();
        $data['collections'] = $collections;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data['title'] = 'Quản lý bộ sưu tập: [Thêm]';
        $data['view']  = $this->viewPath . $this->view . '.add';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductCollectionRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới bộ sưu tập thành công.';
        $error   = 'Thêm mới bộ sưu tập thất bại.';
        $params = $this->productCollectionModel->revertAlias($request->all());

        try {
            $this->productCollectionModel::query()->create($params);
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

        $collection = $this->productCollectionModel::query()->where('pcollection_id', $id)->first();
        if($collection){
            $data['title'] = 'Quản lý bộ sưu tập: [Sao Chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['collection'] = $collection;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy bộ sưu tập';
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
        $collection = $this->productCollectionModel::query()->where('pcollection_id', $id)->first();
        if($collection){
            $data['title'] = 'Quản lý bộ sưu tập: [Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['collection'] = $collection;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy bộ sưu tập';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ProductCollectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductCollectionRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật bộ sưu tập thành công.';
        $error   = 'Cập nhật bộ sưu tập thất bại.';
        $params = $this->productCollectionModel->revertAlias($request->all());

        try {
            $this->productCollectionModel::query()->where('pcollection_id', $id)->update($params);

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
    public function duplicate(ProductCollectionRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép bộ sưu tập thành công.';
        $error   = 'Sao chép bộ sưu tập thất bại.';

        $params = $this->productCollectionModel->revertAlias($request->all());
        unset($params['pcollection_id']);

        try {
            $this->productCollectionModel::query()->create($params);
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
        $success = 'Xóa bộ sưu tập thành công.';
        $error   = 'Xóa bộ sưu tập thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productCollectionModel->query()->whereIn('pcollection_id', $ids)->update(['pcollection_is_delete' => 'yes']);
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
        $success = 'Bật bộ sưu tập thành công.';
        $error   = 'Bật bộ sưu tập thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productCollectionModel->query()->whereIn('pcollection_id', $ids)->update(['pcollection_status' => 'activated']);
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
        $success = 'Tắt bộ sưu tập thành công.';
        $error   = 'Tắt bộ sưu tập thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productCollectionModel->query()->whereIn('pcollection_id', $ids)->update(['pcollection_status' => 'inactive']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
