<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\StringHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth\KiotvietAuthController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\Product;
use VienThuong\KiotVietClient\Criteria\ProductCriteria;
use VienThuong\KiotVietClient\Resource\BranchResource;
use VienThuong\KiotVietClient\Resource\CategoryResource;
use VienThuong\KiotVietClient\Resource\ProductResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;
//
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getKiotvietBranchController;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getKiotvietCateProductController;

class KiotvietProductController extends BaseController
{
    private $view = '.kiotvietproduct';
    private $model = 'kiotvietproduct';
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    private $getBranchCtrl;
    private $getCateProductCtrl;
    private $kiotvietAuth;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->getBranchCtrl = new getKiotvietBranchController();
        $this->getCateProductCtrl = new getKiotvietCateProductController();
        $this->kiotvietAuth = new KiotvietAuthController();
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawProduct()
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $productResource = new ProductResource($client);

        $product = new Product();
        $product->setProductType(Product::PRODUCT_TYPE_NORMAL);

        $criteria = new ProductCriteria($product);

        $criteria->setPageSize(KIOTVIET_DEFAULT_PAGESIZE);
        $criteria->setOrderBy(KIOTVIET_DEFAULT_ORD_BY);
        $criteria->setOrderDirection(KIOTVIET_DEFAULT_ORD_DIRECTION);
        $criteria->setIncludeInventory(KIOTVIET_INC_PROD_INV);
        $products = $productResource->search($criteria);

        dd($products);
    }

    /**
     * @return Application|Factory|View
     */
    public function getProductById($id = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $productResource = new ProductResource($client);
        $product = $productResource->getById($id);

        dd($product);
    }

    /**
     * @return Application|Factory|View
     */
    public function getProductByCode($code = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $productResource = new ProductResource($client);
        $product = $productResource->getByCode($code);

        dd($product);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawProductFirst()
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $customResource = new KiotVietClient\Resource\CustomResource($client);
        $customresponse = $customResource
            ->setExpectedModel(KiotVietClient\Model\Product::class)
            ->setCollectionClass(KiotVietClient\Collection\ProductCollection::class)
            ->setEndPoint(KiotVietClient\Endpoint::PRODUCT_ENDPOINT);

        $product = $customresponse->list()->first();

        dd($product);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawProductByName($searchStr = '', $pageSize = 50)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $productResource = new ProductResource($client);

        $product = new Product();
        $product->setProductType(Product::PRODUCT_TYPE_NORMAL);

        $criteria = new ProductCriteria($product);

        $criteria->setPageSize($pageSize);
        $criteria->addCriteria('name', $product->getName());
        $products = $productResource->search($criteria);

        dd($products);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadindex()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'index';
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->getCateProductCtrl->doQuery('%');
        $data['code'] = $code;
        $data['name'] = $name;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadsearch()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'search';
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->getCateProductCtrl->doQuery('%');
        $data['code'] = $code;
        $data['name'] = $name;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }  

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = KIOTVIET_PRODUCT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        //
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        //
        $client = $this->kiotvietAuth->doCreateClient();
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        //
        $productResource = new ProductResource($client);
        $product = new Product();
        $criteria = new ProductCriteria($product);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection(KIOTVIET_DEFAULT_ORD_DIRECTION);
        //
        $total = KIOTVIET_PRODUCT_PAGINATE;
        //
        $productArr = array();
        $productTotal = 0;
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $products = $productResource->search($criteria);
            $productTotal = $products->getTotal();
            //
            $productItems = $products->getItems();
            foreach ($productItems as $key => $item) 
            {
                $productItems[$item->getId()] = $productItems[$key];
                unset($productItems[$key]);
            }
            $productArr += $productItems;
        }

        // dd($total, count($productArr));

        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->getCateProductCtrl->doQuery('%');
        $data['code'] = $code;
        $data['name'] = $name;
        //
        $productArr = CollectionPaginateHelper::paginateSec($productArr, PAGINATE_PERPAGE);
        // dd($productArr);
        $data['productArr'] = $productArr;
        $data['productTotal'] = $productTotal;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $data['title'] = KIOTVIET_PRODUCT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        //
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        //
        $client = $this->kiotvietAuth->doCreateClient();
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        //
        $productResource = new ProductResource($client);
        $product = new Product();
        $criteria = new ProductCriteria($product);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection(KIOTVIET_DEFAULT_ORD_DIRECTION);
        //
        if($name != '')
        {
            $criteria->setName($name);
        }

        if($cateProduct != '%')
        {
            $criteria->setCategoryId($cateProduct);
        }
        //
        $finds = $productResource->search($criteria);
        $total = $finds->getTotal();
        //
        $productArr = array();
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $products = $productResource->search($criteria);
            //
            $productItems = $products->getItems();
            if($code != '')
            {
                foreach ($productItems as $key => $item) 
                {
                    if($item->getCode() == $code)
                    {
                        $productItems[$item->getId()] = $productItems[$key];
                        unset($productItems[$key]);
                    }
                    else
                    {
                        unset($productItems[$key]);
                    }
                }
            }
            if($name != '')
            {
                foreach ($productItems as $key => $item) 
                {
                    if(strpos($item->getName(), $name) !== false)
                    {
                        $productItems[$item->getId()] = $productItems[$key];
                        unset($productItems[$key]);
                    }
                    else
                    {
                        unset($productItems[$key]);
                    }
                }
            }            
            else
            {
                foreach ($productItems as $key => $item) 
                {
                    $productItems[$item->getId()] = $productItems[$key];
                    unset($productItems[$key]);
                }
            }
            $productArr += $productItems;
        }

        // dd($total, count($productArr));

        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->getCateProductCtrl->doQuery('%');
        $data['code'] = $code;
        $data['name'] = $name;
        //
        $productArr = CollectionPaginateHelper::paginateSec($productArr, PAGINATE_PERPAGE);
        // dd($productArr);
        $data['productArr'] = $productArr;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $productResource = new ProductResource($client);
        //
        $user = Auth::guard('admin')->user();
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        //
        $id = (int) request()->get('id', 0);
        $code = (string) request()->get('code', '');
        if($id != 0)
        {
            $product = $productResource->getById($id);
        }
        if($code != 'code')
        {
            $product = $productResource->getByCode($code);
        }

        if($product){
            $data['title'] = KIOTVIET_PRODUCT_TITLE.SHOW_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['product'] = $product;
            $data['id'] = $product->getId();
            $data['code'] = $product->getCode();            
            $data['name'] = $product->getName();
            $data['fullName'] = $product->getFullName();
            $data['image'] = collect($product->getImages())->first();
            $data['categoryId'] = $product->getCategoryId();
            $data['categoryName'] = $product->getCategoryName();
            $data['allowsSale'] = $product->getIsAllowsSale();
            $data['description'] = $product->getDescription();
            $data['inventories'] = $product->getInventories()->getItems();
            $data['basePrice'] = intval($product->getBasePrice());
            $data['createdDate'] = $product->getCreatedDate();
            $data['modifiedDate'] = $product->getModifiedDate();
            $data['retailerId'] = $product->getRetailerId();
            $data['otherProperties'] = $product->getOtherProperties();

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy sản phẩm';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}