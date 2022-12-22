<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ArrayHelper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\Producer;
use App\Models\ProductCategory;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductCollection;
use App\Models\ProductNutritions;
use App\Models\ProductOdorous;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends BaseController
{
    private $view = '.product';
    private $model = 'product';
    private $productModel;
    private $imageModel;
    private $adminUserModel;
    private $producerModel;
    private $productSizeModel;
    private $productColorModel;
    private $productCollectionModel;
    private $productNutritionsModel;
    private $productOdorousModel;
    private $productCategoryModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->producerModel = new Producer();
        $this->imageModel = new Image();
        $this->productSizeModel = new ProductSize();
        $this->productColorModel = new ProductColor();
        $this->productCollectionModel = new ProductCollection();
        $this->productNutritionsModel = new ProductNutritions();
        $this->productOdorousModel = new ProductOdorous();
        $this->adminUserModel = new AdminUser();
        $this->productCategoryModel = new ProductCategory();
    }

    /**
     * Lấy danh sach theo $type
     * @return Application|Factory|View
     */
    public function type()
    {
        return \view($this->viewPath . $this->view . '.type');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $type = \request()->get('type', 'shoes');
        $type = in_array($type, ['shoes', 'cosmetic']) ? $type : 'shoes';

        $data['title'] = $type == 'shoes' ? 'Sản phẩm Giày' : 'Sản phẩm Mỹ Phẩm';
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['type']  = $type;

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $valueAvatar = config('my.image.value.product.avatar');


        $products = $this->productModel::query()->where('product_type', $type)->get();
        $producers = $this->producerModel::query()->get();
        $data['producers'] = array_combine(array_column($producers->toArray(), 'producer_id'), array_column($producers->toArray(), 'producer_name'));

        if($products->count() > 0){
            foreach ($products as $key => $item){
                $producer = $this->producerModel->query()->where('producer_id', $item->producer)->first();
                $item->producerName = !empty($producer->producer_name) ? $producer->producer_name : '';
                $item->urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';
            }
        }
        $data['products'] = $products;
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $type = \request()->get('type', 'shoes');
        $type = in_array($type, ['shoes', 'cosmetic']) ? $type : 'shoes';
        $data['type'] = $type;
        $data['title'] = $type == 'shoes' ? 'Sản phẩm Giày: [Thêm]' : 'Sản phẩm Mỹ Phẩm: [Thêm]';
        $user = Auth::guard('admin')->user();
        $data['view']  = $this->viewPath . $this->view . '.add';
        $data['adminName']  = $user->username;
        $data['producers'] = $this->producerModel::query()
                                ->select('producer_id', 'producer_name')
                                ->where('producer_type', $type)
                                ->get()->toArray();
        $data['products'] = $this->productModel::query()->where('product_type', $type)->get();
        $data['colors'] = $this->productColorModel::query()->get();
        $data['sizes'] = $this->productSizeModel::query()->get();
        $data['collections'] = $this->productCollectionModel::query()->get();
        $data['nutritions'] = $this->productNutritionsModel::query()->get();
        $data['odorous'] = $this->productOdorousModel::query()->get();
        $data['productCategories'] = $this->productCategoryModel->findByType($type);

        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $type = !empty($request->type) ? $request->type : 'shoes';
        $actionType = request()->post('action_type', 'save');
        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model, 'index',['type' => $type]);
        }else{
            $redirect = UrlHelper::admin($this->model,'create', ['type' => $type]);
        }

        $success = 'Đã thêm mới sản phẩm thành công.';
        $error   = 'Thêm mới sản phẩm thất bại.';

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $valueAvatar = config('my.image.value.product.avatar');
        $pathSaveAvatar = $this->model.'_m/avatar';

        $pathThumbnail = config('my.path.image_product_thumbnail_of_module');
        $valueThumbnail = config('my.image.value.product.thumbnail');
        $pathSaveThumbnail = $this->model.'_m/thumbnail';

        $pathBanner = config('my.path.image_product_banner_of_module');
        $valueBanner = config('my.image.value.product.banner');
        $pathSaveBanner = $this->model.'_m/banner';

        $user = Auth::guard('admin')->user();
        $params = $this->productModel->revertAlias($request->all());
        $params['product_created_by'] = $user->aduser_id;

        if($request->related){
            $params['product_related'] = array_diff(array_map('intval', $params['product_related']), [0]);
            $params['product_related'] = $this->producerModel->getIds($params['product_related']);
        }

        try {
            $productId = 0;
            $product = $this->productModel::query()->create($params);
            if($product){
                $productId = $product->product_id;
            }

            if($request->color != null){
                $color = $request->color;
                $product->colors()->sync($color);
            }
            if($request->size != null){
                $size = $request->size;
                $product->sizes()->sync($size);
            }
            if($request->collection != null){
                $collection = $request->collection;
                $product->collections()->sync($collection);
            }
            if($request->nutritions != null){
                $nutritions = $request->nutritions;
                $product->nutritions()->sync($nutritions);
            }
            if($request->odorous != null){
                $odorous = $request->odorous;
                $product->odorous()->sync($odorous);
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $productId, $valueAvatar, $pathSaveAvatar);
            }
            $imageColor = [];
            if($request->imageColor != null && count($request->imageColor) > 0){
                $imageColor = $request->imageColor;
            }
            if($request->imageThumbnail != null && count($request->imageThumbnail) > 0){
                $imageThumbnail = $request->imageThumbnail;
                ImageHelper::uploadMultipleImage($imageThumbnail, $this->model, $productId, $valueThumbnail, $pathSaveThumbnail, $imageColor);
            }
            if($request->imageBanner != null && count($request->imageBanner) > 0){
                $imageBanner = $request->imageBanner;
                ImageHelper::uploadMultipleImage($imageBanner, $this->model, $productId, $valueBanner, $pathSaveBanner, $imageColor);
            }

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'create', ['type' => $type]);
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
        $user = Auth::guard('admin')->user();
        $type = \request()->post('type', 'shoes');
        $type = in_array($type, ['shoes', 'cosmetic']) ? $type : 'shoes';

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $valueAvatar = config('my.image.value.product.avatar');

        $pathThumbnail = config('my.path.image_product_thumbnail_of_module');
        $valueThumbnail = config('my.image.value.product.thumbnail');

        $pathBanner = config('my.path.image_product_banner_of_module');
        $valueBanner = config('my.image.value.product.banner');

        $product = $this->productModel::query()->where('product_id', $id)->first();
        if($product){
            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            $imageThumbnail = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueThumbnail])->orderBy('image_id', 'ASC')->get();
            $imageBanner = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueBanner])->orderBy('image_id', 'ASC')->get();


            $data['type'] = $type;
            $data['title'] = $type == 'shoes' ? 'Sản phẩm Giày: [Sao chép]' : 'Sản phẩm Mỹ Phẩm: [Sao chép]';
            $data['view']  = $this->viewPath . $this->view . '.copy';
            $data['adminName'] = !empty($creater) ? $creater->username : '';
            $data['product'] = $product;
            $data['urlBanner'] = '';
            $data['urlThumbnail'] = '';
            $data['products'] = $this->productModel::query()->where([['product_type' ,'=', $type], ['product_id', '!=', $id]])->get();

            $pColor = $product->colors()->get()->toArray();
            $pSize = $product->sizes()->get()->toArray();
            $pCollection = $product->collections()->get()->toArray();
            $pNutritions = $product->nutritions()->get()->toArray();
            $pOdorous = $product->odorous()->get()->toArray();

            $data['pColor'] = array_column($pColor, 'pcolor_id');
            $data['pSize'] = array_column($pSize, 'psize_id');
            $data['pCollection'] = array_column($pCollection, 'pcollection_id');
            $data['pNutritions'] = array_column($pNutritions, 'pnutri_id');
            $data['pOdorous'] = array_column($pOdorous, 'podo_id');


            $data['colors'] = $this->productColorModel::query()->get();
            $data['sizes'] = $this->productSizeModel::query()->get();
            $data['collections'] = $this->productCollectionModel::query()->get();
            $data['nutritions'] = $this->productNutritionsModel::query()->get();
            $data['odorous'] = $this->productOdorousModel::query()->get();

            $data['arrayRelated'] = !empty($product->product_related) ? array_diff(array_map('intval', explode(',', $product->product_related)), [0]) : [];
            $data['producers'] = $this->producerModel::query()
                                ->select('producer_id', 'producer_name')
                                ->where('producer_type', $type)
                                ->get()
                                ->toArray();
            $data['thumbnailIds'] = array_column($imageThumbnail->toArray(), 'image_id');
            $data['bannerIds'] = array_column($imageBanner->toArray(), 'image_id');
            $data['colorImageIds'] = array_column($imageBanner->toArray(), 'rd_type_2');

            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
                $data['avatarId'] = $imageAvatar->image_id;
            }
            if($imageThumbnail->count() > 0) {
                foreach ($imageThumbnail as $key => $itemT){
                    $data['thumbnail'][] = [
                        'link' => $pathThumbnail . $itemT->image_name,
                        'id' => $itemT->image_id,
                        'color' => $itemT->rd_type_2,
                    ];
                }
            }
            if($imageBanner->count() > 0) {
                foreach ($imageBanner as $key => $itemB){
                    $data['banner'][] = [
                        'link' => $pathBanner . $itemB->image_name,
                        'id' => $itemB->image_id,
                        'color' => $itemB->rd_type_2,
                    ];
                }
            }


            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy sản phẩm';
            $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
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
        $type = \request()->get('type', 'shoes');
        $type = in_array($type, ['shoes', 'cosmetic']) ? $type : 'shoes';

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $valueAvatar = config('my.image.value.product.avatar');

        $pathThumbnail = config('my.path.image_product_thumbnail_of_module');
        $valueThumbnail = config('my.image.value.product.thumbnail');

        $pathBanner = config('my.path.image_product_banner_of_module');
        $valueBanner = config('my.image.value.product.banner');

        $product = $this->productModel::query()->where('product_id', $id)->first();
        if($product){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $product->product_created_by)->first();

            $imageAvatar  = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueAvatar])->first();
            $imageThumbnail = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueThumbnail])->orderBy('image_id', 'ASC')->get();
            $imageBanner = $this->imageModel->query()->where(['3rd_key' => $id, '3rd_type' => $this->model, 'image_value' => $valueBanner])->orderBy('image_id', 'ASC')->get();

            $data['type'] = $type;
            $data['title'] = $type == 'shoes' ? 'Sản phẩm Giày: [Sửa]' : 'Sản phẩm Mỹ Phẩm: [Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['product'] = $product;
            $data['urlAvatar'] = '';

            $data['products'] = $this->productModel::query()->where([['product_type' ,'=', $type], ['product_id', '!=', $id]])->get();
            $pColor = $product->colors()->get()->toArray();
            $pSize = $product->sizes()->get()->toArray();
            $pCollection = $product->collections()->get()->toArray();
            $pNutritions = $product->nutritions()->get()->toArray();
            $pOdorous = $product->odorous()->get()->toArray();

            $data['productCategories'] = $this->productCategoryModel->findByType($product->product_type);
            $data['pColor'] = array_column($pColor, 'pcolor_id');
            $data['pSize'] = array_column($pSize, 'psize_id');
            $data['pCollection'] = array_column($pCollection, 'pcollection_id');
            $data['pNutritions'] = array_column($pNutritions, 'pnutri_id');
            $data['pOdorous'] = array_column($pOdorous, 'podo_id');

            $data['colors'] = $this->productColorModel::query()->get();
            $data['sizes'] = $this->productSizeModel::query()->get();
            $data['collections'] = $this->productCollectionModel::query()->get();
            $data['nutritions'] = $this->productNutritionsModel::query()->get();
            $data['odorous'] = $this->productOdorousModel::query()->get();

            $data['arrayRelated'] = !empty($product->product_related) ? array_diff(array_map('intval', explode(',', $product->product_related)), [0]) : [];
            $data['adminName'] = !empty($creater) ? $creater->username : '';
            $data['producers'] = $this->producerModel::query()
                                    ->select('producer_id', 'producer_name')
                                    ->where('producer_type', $type)
                                    ->get()->toArray();
            $data['thumbnailIds'] = array_column($imageThumbnail->toArray(), 'image_id');
            $data['bannerIds'] = array_column($imageBanner->toArray(), 'image_id');
            $data['colorImageIds'] = count(array_column($imageThumbnail->toArray(), 'rd_type_2')) >= count(array_column($imageBanner->toArray(), 'rd_type_2')) ? array_column($imageThumbnail->toArray(), 'rd_type_2') : array_column($imageBanner->toArray(), 'rd_type_2');


            if($imageAvatar) {
                $data['urlAvatar'] = $pathAvatar . $imageAvatar->image_name;
            }
            if($imageThumbnail->count() > 0) {
                foreach ($imageThumbnail as $key => $itemT){
                    $data['thumbnail'][] = [
                        'link'  => $pathThumbnail . $itemT->image_name,
                        'id'    => $itemT->image_id,
                        'color' => $itemT->rd_type_2,
                    ];
                }
            }

            if($imageBanner->count() > 0) {
                foreach ($imageBanner as $key => $itemB){
                    $data['banner'][] = [
                        'link'  => $pathBanner . $itemB->image_name,
                        'id'    => $itemB->image_id,
                        'color' => $itemB->rd_type_2,
                    ];
                }
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy sản phẩm';
            $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);
        $type = !empty($request->type) ? $request->type : 'shoes';

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id, 'type' => $type]);
        }

        $success = 'Cập nhật sản phẩm thành công.';
        $error   = 'Cập nhật sản phẩm thất bại.';

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $valueAvatar = config('my.image.value.product.avatar');
        $pathSaveAvatar = $this->model.'_m/avatar';

        $pathThumbnail = config('my.path.image_product_thumbnail_of_module');
        $valueThumbnail = config('my.image.value.product.thumbnail');
        $pathSaveThumbnail = $this->model.'_m/thumbnail';

        $pathBanner = config('my.path.image_product_banner_of_module');
        $valueBanner = config('my.image.value.product.banner');
        $pathSaveBanner = $this->model.'_m/banner';


        $params = $this->productModel->revertAlias(request()->all());
        if($request->related){
            $params['product_related'] = array_diff(array_map('intval', $params['product_related']), [0]);
            $params['product_related'] = $this->producerModel->getIds($params['product_related']);
        }

        try {
            $product = $this->productModel::query()->where('product_id', $id)->first();
            $product->update($params);

            if($request->color != null){
                $color = $request->color;
                $product->colors()->sync($color);
            }
            if($request->size != null){
                $size = $request->size;
                $product->sizes()->sync($size);
            }
            if($request->collection != null){
                $collection = $request->collection;
                $product->collections()->sync($collection);
            }
            if($request->nutritions != null){
                $nutritions = $request->nutritions;
                $product->nutritions()->sync($nutritions);
            }
            if($request->odorous != null){
                $odorous = $request->odorous;
                $product->odorous()->sync($odorous);
            }


            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;

                /**check image exist*/
                $image = Image::query()->where(['3rd_key' => $id, '3rd_type' => $this->model,  'image_value' => $valueAvatar])->first();
                if($image){
                    ImageHelper::uploadUpdateImage($imageAvatar, $valueAvatar, $image->image_id, $pathSaveAvatar);
                }else{
                    ImageHelper::uploadImage($imageAvatar, $this->model, $id, $valueAvatar, $pathSaveAvatar);
                }
            }

            /** cập nhật delete*/
            $thumbnailIds = json_decode($request->thumbnailIds);
            $bannerIds = json_decode($request->bannerIds);

            if($request->tIds != null && count($request->tIds) > 0){
                $tIds = $request->tIds;
                $arrayDelete = array_diff($thumbnailIds, $tIds);
                if(count($arrayDelete) > 0){
                    $this->imageModel->query()->whereIn('image_id', $arrayDelete)->update(['image_is_deleted' => 'yes']);
                }
            }

            if($request->bIds != null && count($request->bIds) > 0){
                $bIds = $request->bIds;
                $arrayDelete = array_diff($bannerIds, $bIds);
                if(count($arrayDelete) > 0){
                    $this->imageModel->query()->whereIn('image_id', $arrayDelete)->update(['image_is_deleted' => 'yes']);
                }
            }

            /**upload update*/
            if($request->dataThumbnailUpdate != null && count($request->dataThumbnailUpdate) > 0){
                $dataThumbnailUpdate = $request->dataThumbnailUpdate;
                foreach ($dataThumbnailUpdate as $key => $itemThumbnail){
                    ImageHelper::uploadUpdateImage($itemThumbnail, $valueThumbnail, $key, $pathSaveThumbnail);
                }
            }
            if($request->dataBannerUpdate != null && count($request->dataBannerUpdate) > 0){
                $dataBannerUpdate = $request->dataBannerUpdate;
                foreach ($dataBannerUpdate as $key => $itemBanner){
                    ImageHelper::uploadUpdateImage($itemBanner, $valueBanner, $key, $pathSaveBanner);
                }
            }

            /** upload create*/
            if($request->dataThumbnailCreate != null && count($request->dataThumbnailCreate) > 0){
                $dataThumbnailCreate = $request->dataThumbnailCreate;
                foreach ($dataThumbnailCreate as $key => $itemThumbnail){
                    ImageHelper::uploadImage($itemThumbnail, $this->model, $id, $valueThumbnail, $pathSaveThumbnail);

                }
            }
            if($request->dataBannerCreate != null && count($request->dataBannerCreate) > 0){
                $dataBannerCreate = $request->dataBannerCreate;
                foreach ($dataBannerCreate as $key => $itemBanner){
                    ImageHelper::uploadImage($itemBanner, $this->model, $id, $valueBanner, $pathSaveBanner);

                }
            }

            /** update color cho thumnail vả banner*/
            $dataColorUpdate = $request->dataColorUpdate ? $request->dataColorUpdate : [];
            if(count($dataColorUpdate) > 0){
                $this->imageModel->updateColor($dataColorUpdate, $this->model, $id);
            }


            $imageColor = [];
            if($request->imageColor != null && count($request->imageColor) > 0){
                $imageColor = $request->imageColor;
            }
            if($request->imageThumbnail != null && count($request->imageThumbnail) > 0){
                $imageThumbnail = $request->imageThumbnail;
                ImageHelper::uploadMultipleImage($imageThumbnail, $this->model, $id, $valueThumbnail, $pathSaveThumbnail,$imageColor);
            }
            if($request->imageBanner != null && count($request->imageBanner) > 0) {
                $imageBanner = $request->imageBanner;
                ImageHelper::uploadMultipleImage($imageBanner, $this->model, $id, $valueBanner, $pathSaveBanner, $imageColor);
            }

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(ProductRequest $request)
    {
        $type = !empty($request->type) ? $request->type : 'shoes';
        $user = Auth::guard('admin')->user();
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id, 'type' => $type]);
        }

        $success = 'Sao chép sản phẩm thành công.';
        $error   = 'Sao chép sản phẩm thất bại.';

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $valueAvatar = config('my.image.value.product.avatar');
        $pathSaveAvatar = $this->model.'_m/avatar';

        $pathThumbnail = config('my.path.image_product_thumbnail_of_module');
        $valueThumbnail = config('my.image.value.product.thumbnail');
        $pathSaveThumbnail = $this->model.'_m/thumbnail';

        $pathBanner = config('my.path.image_product_banner_of_module');
        $valueBanner = config('my.image.value.product.banner');
        $pathSaveBanner = $this->model.'_m/banner';

        $params = $this->productModel->revertAlias($request->all());
        $params['product_created_by'] = $user->aduser_id;
        unset($params['product_id']);

        if($request->related){
            $params['product_related'] = array_diff(array_map('intval', $params['product_related']), [0]);
            $params['product_related'] = $this->producerModel->getIds($params['product_related']);
        }

        try {
            $productId = 0;
            $product = $this->productModel::query()->create($params);
            if($product){
                $productId = $product->product_id;
            }

            if($request->color != null){
                $color = $request->color;
                $product->colors()->sync($color);
            }
            if($request->size != null){
                $size = $request->size;
                $product->sizes()->sync($size);
            }
            if($request->collection != null){
                $collection = $request->collection;
                $product->collections()->sync($collection);
            }
            if($request->nutritions != null){
                $nutritions = $request->nutritions;
                $product->nutritions()->sync($nutritions);
            }
            if($request->odorous != null){
                $odorous = $request->odorous;
                $product->odorous()->sync($odorous);
            }

            if($request->imageAvatar != null){
                $imageAvatar = $request->imageAvatar;
                ImageHelper::uploadImage($imageAvatar, $this->model, $productId, $valueAvatar, $pathSaveAvatar);
            }else{
                /**duplicate image avatar*/
                $avatarId = (int)$request->avatarId;
                $imageAvatar = $this->imageModel->getDataDuplicate($avatarId);
                if($imageAvatar){
                    $imageAvatar = $imageAvatar->toArray();
                    $imageAvatar['3rd_key'] = $productId;
                    $imageAvatar['3rd_type'] = $this->model;
                    $this->imageModel->query()->create($imageAvatar);
                }
            }

            /** upload duplicate */
            if($request->tIds != null && count($request->tIds) > 0){
                $tIds = $request->tIds;
                if(count($tIds) > 0){
                    $arrayImage = $this->imageModel->getArrayDataDuplicate($tIds);
                    if($arrayImage->count() > 0){
                        $arrayImage = $arrayImage->toArray();
                        foreach ($arrayImage as $key => $item){
                            $arrayImage[$key]['3rd_key'] = $productId;
                            $arrayImage[$key]['3rd_type'] = $this->model;
                        }
                        $this->imageModel->query()->insert($arrayImage);
                    }
                }
            }
            if($request->bIds != null && count($request->bIds) > 0){
                $bIds = $request->bIds;
                if(count($bIds) > 0){
                    $arrayImage = $this->imageModel->getArrayDataDuplicate($bIds);
                    if($arrayImage->count() > 0){
                        $arrayImage = $arrayImage->toArray();
                        foreach ($arrayImage as $key => $item){
                            $arrayImage[$key]['3rd_key'] = $productId;
                            $arrayImage[$key]['3rd_type'] = $this->model;
                        }
                        $this->imageModel->query()->insert($arrayImage);
                    }
                }
            }

            /** upload create*/
            $imageColor = [];
            if($request->imageColor != null && count($request->imageColor) > 0){
                $imageColor = $request->imageColor;
            }
            if($request->imageThumbnail != null && count($request->imageThumbnail) > 0){
                $imageThumbnail = $request->imageThumbnail;
                ImageHelper::uploadMultipleImage($imageThumbnail, $this->model, $productId, $valueThumbnail, $pathSaveThumbnail, $imageColor);


            }
            if($request->imageBanner != null && count($request->imageBanner) > 0) {
                $imageBanner = $request->imageBanner;
                ImageHelper::uploadMultipleImage($imageBanner, $this->model, $productId, $valueBanner, $pathSaveBanner, $imageColor);

            }

            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $type = !empty($request->type) ? $request->type : 'shoes';

        $ids = request()->post('cid', []);
        $success = 'Xóa sản phẩm thành công.';
        $error   = 'Xóa sản phẩm thất bại.';

        $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
        $number = $this->productModel->query()->whereIn('product_id', $ids)->update(['product_is_delete' => 'yes']);
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
        $type = !empty($request->type) ? $request->type : 'shoes';
        $ids = request()->post('cid', []);
        $success = 'Bật sản phẩm thành công.';
        $error   = 'Bật sản phẩm thất bại.';

        $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
        $number = $this->productModel->query()->whereIn('product_id', $ids)->update(['product_status_show' => 'yes']);
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
        $type = !empty($request->type) ? $request->type : 'shoes';
        $ids = request()->post('cid', []);
        $success = 'Tắt sản phẩm thành công.';
        $error   = 'Tắt sản phẩm thất bại.';

        $redirect = UrlHelper::admin($this->model, 'index', ['type' => $type]);
        $number = $this->productModel->query()->whereIn('product_id', $ids)->update(['product_status_show' => 'no']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
