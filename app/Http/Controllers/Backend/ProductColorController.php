<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductColorRequest;
use App\Models\ProductColor;
use App\Models\AdminUser;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductColorController extends BaseController
{
    private $view = '.productcolor';
    private $model = 'productcolor';
    private $productColorModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->productColorModel = new ProductColor();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Quản lý màu';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $colors = $this->productColorModel::query()->get();
        $data['colors'] = $colors;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return false|string
     */
    public function list()
    {
        $colors = $this->productColorModel::query()->select('pcolor_id', 'pcolor_code', 'pcolor_hex')->where('pcolor_status', 'activated')->get();
        $html = "<select name='imageColor[]' class='form-control custom-select form-control custom-select-sm'>
                    <option value='0'>Chọn màu</option>";
        if($colors->count() > 0){
            foreach ($colors as $key => $item){
                $html .= "<option value='".$item->pcolor_id."'>$item->pcolor_code</option>";
            }
        }
        $html .= "<select>";
        return $html;
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data['title'] = 'Quản lý màu[Thêm]';
        $data['view']  = $this->viewPath . $this->view . '.add';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductColorRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'create');
        }

        $success = 'Đã thêm mới màu thành công.';
        $error   = 'Thêm mới màu thất bại.';
        $params = $this->productColorModel->revertAlias($request->all());

        try {
            $this->productColorModel::query()->create($params);
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

        $color = $this->productColorModel::query()->where('pcolor_id', $id)->first();
        if($color){
            $data['title'] = 'Quản lý màu[Sao Chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['color'] = $color;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy màu';
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
        $color = $this->productColorModel::query()->where('pcolor_id', $id)->first();
        if($color){
            $data['title'] = 'Quản lý màu[Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['color'] = $color;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy màu';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ProductColorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductColorRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật màu thành công.';
        $error   = 'Cập nhật màu thất bại.';
        $params = $this->productColorModel->revertAlias(request()->post());

        try {
            $this->productColorModel::query()->where('pcolor_id', $id)->update($params);

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
    public function duplicate(ProductColorRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Sao chép màu thành công.';
        $error   = 'Sao chép màu thất bại.';

        $params = $this->productColorModel->revertAlias($request->all());
        unset($params['pcolor_id']);

        try {
            $this->productColorModel::query()->create($params);
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
        $success = 'Xóa màu thành công.';
        $error   = 'Xóa màu thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productColorModel->query()->whereIn('pcolor_id', $ids)->update(['pcolor_is_delete' => 'yes']);
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
        $success = 'Bật màu thành công.';
        $error   = 'Bật màu thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productColorModel->query()->whereIn('pcolor_id', $ids)->update(['pcolor_status' => 'activated']);
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
        $success = 'Tắt màu thành công.';
        $error   = 'Tắt màu thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->productColorModel->query()->whereIn('pcolor_id', $ids)->update(['pcolor_status' => 'inactive']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
