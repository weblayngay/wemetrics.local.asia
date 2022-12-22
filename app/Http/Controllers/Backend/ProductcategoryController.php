<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UrlHelper;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductcategoryController extends BaseController
{
    private $view = 'productcategory';

    /**
     * @var ProductCategory
     */
    private ProductCategory $productCategoryModel;

    public function __construct(ProductCategory $productCategoryModel)
    {
        $this->productCategoryModel = $productCategoryModel;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return \view($this->viewPath . $this->view . '.index');
    }

    /**
     * Lấy danh sach theo $type
     * @return Application|Factory|View
     */
    public function type()
    {
        $type = \request()->get('type', 'shoes');
        $type = in_array($type, ['shoes', 'cosmetic']) ? $type : 'shoes';

        $data['type'] = $type;
        $data['productCategories'] = $this->productCategoryModel->findByType($type);
        $data['title'] = $type == 'shoes' ? 'Nhóm sản phẩm của Giày' : 'Nhóm sản phẩm của Mỹ Phẩm';

        return \view($this->viewPath . $this->view . '.type', compact('data'));
    }


    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function detail()
    {
        $id = \request()->get('id', null);
        $type = in_array(\request()->get('type', 'shoes'), ['shoes', 'cosmetic']) ? \request()->get('type', 'shoes') : 'shoes';
        $title = 'Nhóm sản phẩm của Mỹ phẩm';
        if ($type == 'shoes'){
            $title = 'Nhóm sản phẩm của Giày';
        }

        $data['title'] = "$title: [Thêm]";
        if ($id != null) {
            $data['title'] = "$title: [Sửa]";
            $productCategory = $this->productCategoryModel::parentQuery()->whereNotIn('pcat_id', $this->productCategoryModel::NODE_ROOT)->find($id);
            $data['productCategory'] = $productCategory;
            if (!$productCategory){
                return redirect()
                    ->to(UrlHelper::admin('productcategory', 'index'))
                    ->with('error', "$title không tìm thấy");
            }
        }

        $data['productCategories'] = $this->productCategoryModel->findByType($type);
        $data['type'] = $type;
        return view($this->viewPath . $this->view . '.detail' , compact('data'));
    }


    /**
     * @param ProductCategoryRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function save(ProductCategoryRequest $request)
    {
        $id     = $request->post('id', null);
        $status = $request->post('pcat_status');
        $name   = $request->post('pcat_name', '');
        $parent = $request->post('parent', 1);

        $type       = $request->post('type', 'shoes');
        $groupValue = ($type== 'shoes') ? 'Giày' : 'Mỹ phẩm';

        $data = [
            'parent'       => $parent,
            'pcat_name'    => strip_tags($name),
            'pcat_status'  => ($status == 'activated') ? 'activated' : 'inactive',
        ];

        $message = "Tạo mới nhóm $groupValue thành công.";
        if ($id > 0){ // Update
            $message = "Cập nhật nhóm $groupValue thành công.";
            $productCategory = $this->productCategoryModel::parentQuery()->whereNotIn('pcat_id', $this->productCategoryModel::NODE_ROOT)->find($id);
            if (!$productCategory) {
                return redirect()
                    ->to(UrlHelper::admin('productcategory', 'index'))
                    ->with('error', "Nhóm $groupValue không tìm thấy") ;
            } else {
                $this->productCategoryModel->updateNode($data, $id);
            }
        }else{ // Create new
            if ($this->productCategoryModel->createNode($data)) {
                $lastProductCategory = $this->productCategoryModel::parentQuery()->orderBy('pcat_id', 'desc')->first();
                $id = $lastProductCategory->pcat_id;
            }else{
                return redirect()
                    ->to(UrlHelper::admin('productcategory', 'index'))
                    ->with('error', "Nhóm $groupValue không tìm thấy") ;
            }
        }

        if ($request->post('action_type') == 'save') {
            return redirect()->to(UrlHelper::admin('productcategory', 'type', ['type' => $type]))->with('success', $message);
        } else {
            return redirect()->to(UrlHelper::admin('productcategory', 'detail', ['id' => $id, 'type' => $type]))->with('success', $message) ;
        }
    }


    /**
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(): RedirectResponse
    {
        $type            = request()->get('type', 'shoes');
        $id              = request()->get('id');
        $productCategory = $this->productCategoryModel::parentQuery()
                            ->whereNotIn('pcat_id', $this->productCategoryModel::NODE_ROOT)
                            ->find($id);
        $groupValue      = ($type == 'shoes') ? 'Giày' : 'Mỹ phẩm';
        if (!$productCategory) {
            return redirect()
                ->to(UrlHelper::admin('productcategory', 'type', ['type' => $type]))
                ->with('error', "Nhóm $groupValue không tìm thấy") ;
        }

        $partnerId = $this->productCategoryModel::TYPE[$type];
        $this->productCategoryModel->deleteNode(['pcat_id' => $id], $partnerId);
        return redirect()
            ->to(UrlHelper::admin('productcategory', 'type', ['type' => $type]))
            ->with('success', "Xóa nhóm $groupValue thành công") ;
    }

}
