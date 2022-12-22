<?php

namespace App\Http\Controllers\Backend\Campaign;

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
use App\Helpers\CollectionPaginateHelper;
use App\Models\AdminUser;
use App\Models\Campaign;
use App\Models\CampaignResult;


class CampaignResultController extends BaseController
{
    private $view = '.campaignresult';
    private $model = 'campaignresult';
    private $campaignModel;
    private $campaignResultModel;
    private $imageModel;
    private $adminUserModel;
    public function __construct()
    {
        $this->campaignModel = new Campaign();
        $this->campaignResultModel = new CampaignResult();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CAMPAIGN_RESULT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['campaigns'] = $this->campaignModel::query()->IsActivated()->get();
        $campaignresults = $this->campaignResultModel::query2nd();
        $data['campaignresults'] = !empty($campaignresults) ? CollectionPaginateHelper::paginate($campaignresults, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function show()
    {
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $campaignresult = $this->campaignResultModel::query()->where('campaignresult_id', $id)->first();
        $pathSave = $this->model.'_m';

        if($campaignresult){
            $creater  = $this->adminUserModel::query()->where('aduser_id', $campaignresult->campaignresult_created_by)->first();
            $data['title'] = CAMPAIGN_RESULT_TITLE.SHOW_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.show';
            $data['campaignresult'] = $campaignresult;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;
            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy chiến dịch';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $campaign, string $voucher, string $isUsed, int $paginateNum)
    {
        $columnArr = ['object_name', 'object_email', 'object_phone', 'browser', 'deviceType', 'platform'];
        foreach($columnArr as $key => $column)
        {
            $campaignresults = $this->campaignResultModel::search($column, $searchStr, $campaign, $voucher, $isUsed, $paginateNum);
            if(!empty($campaignresults) > 0 && count($campaignresults) > 0)
            {
                return $campaignresults;
                break;
            }
        }
        return null; //If can not find any records follow the column;
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $campaign = (string) strip_tags(request()->post('campaign', ''));
        $searchStr = (string) strip_tags(request()->post('searchStr', ''));
        $voucher = (string) strip_tags(request()->post('voucher', ''));
        $isUsed = (string) strip_tags(request()->post('isUsed', ''));
        $data['title'] = CAMPAIGN_RESULT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';
        $data['campaigns'] = $this->campaignModel::query()->IsActivated()->get();
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $campaignresults = $this->searchQuery($searchStr, $campaign, $voucher, $isUsed, PAGINATE_PERPAGE);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['campaignresults'] = !empty($campaignresults) ? CollectionPaginateHelper::paginate($campaignresults, PAGINATE_PERPAGE) : [];
        return view($data['view'] , compact('data'));
    }
}
