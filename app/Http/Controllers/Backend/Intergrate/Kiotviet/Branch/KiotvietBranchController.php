<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch;

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
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth\KiotvietAuthController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\Branch;
use VienThuong\KiotVietClient\Criteria\BranchCriteria;
use VienThuong\KiotVietClient\Resource\BranchResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;


class KiotvietBranchController extends BaseController
{
    private $view = '.kiotvietbranch';
    private $model = 'kiotvietbranch';
    private $imageModel;
    private $adminUserModel;
    private $branchModel;
    private $adminMenu;
    private $kiotvietAuth;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->branchModel = new Branch();
        $this->kiotvietAuth = new KiotvietAuthController();
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawBranch($pageSize = 50)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $customResource = new KiotVietClient\Resource\CustomResource($client);
        $customresponse = $customResource
            ->setExpectedModel(KiotVietClient\Model\Branch::class)
            ->setCollectionClass(KiotVietClient\Collection\BranchCollection::class)
            ->setEndPoint(KiotVietClient\Endpoint::BRANCH_ENDPOINT);
        //
        $branch = new Branch();
        $criteria = new BranchCriteria($branch);
        $criteria->setPageSize(100);
        //
        $branchs = $customresponse->search($criteria);

        dd($branchs);
    }

    /**
     * @return Application|Factory|View
     */
    public function getBranchByCode($code = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $customResource = new KiotVietClient\Resource\CustomResource($client);
        $customresponse = $customResource
            ->setExpectedModel(KiotVietClient\Model\Branch::class)
            ->setCollectionClass(KiotVietClient\Collection\BranchCollection::class)
            ->setEndPoint(KiotVietClient\Endpoint::BRANCH_ENDPOINT);
        //
        $branch = new Branch();
        $criteria = new BranchCriteria($branch);
        $criteria->setPageSize(100);
        //
        $branchs = $customresponse->search($criteria);
        $branchObjs = (object) $branchs->getItems();
        $result = (object) [];
        foreach($branchObjs as $key => $item)
        {
            if($item->getBranchCode() == $code)
            {
                $result = (object) $item;
                break;
            }
        }

        // dd($result);
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function getBranchById($id = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $customResource = new KiotVietClient\Resource\CustomResource($client);
        $customresponse = $customResource
            ->setExpectedModel(KiotVietClient\Model\Branch::class)
            ->setCollectionClass(KiotVietClient\Collection\BranchCollection::class)
            ->setEndPoint(KiotVietClient\Endpoint::BRANCH_ENDPOINT);
        //
        $branch = new Branch();
        $criteria = new BranchCriteria($branch);
        $criteria->setPageSize(100);
        $criteria->setId($id);
        //
        $branchs = $customresponse->search($criteria);
        $branch = collect([]);
        foreach($branchs as $key => $item)
        {
            if($item->getId() == $id)
            {
                $branch[$key] = $item;
            }
        }
        $result = $branch->first();
        // dd($id, $result);
        return $result;
    }
}