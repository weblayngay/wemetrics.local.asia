<?php

namespace App\Http\Controllers\Frontend\Camp\Coupon202208\Page;

use App\Http\Controllers\Frontend\BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Artesaos\SEOTools\Traits\SEOTools;
use App\Models\Banner;
use App\Models\Block;
use App\Models\Config;
use App\Models\Voucher;
use App\Models\Campaign;
use App\Models\CampaignResult;
use Jenssegers\Agent\Agent;
use Validator;

class Coupon202208Controller extends BaseController
{
    use SEOTools;
    /**
     * @var Banner
     */
    private Banner $bannerModel;

    /**
     * @var Config
     */
    private Config $configModel;


    /**
     * @var Block
     */
    private Block $blockModel;

    /**
     * @var Voucher
     */
    private Voucher $voucherModel;

    /**
     * @var Campaign
     */
    private Campaign $campaignModel;

    /**
     * @var CampaignResult
     */
    private CampaignResult $campaignResultModel;

    /**
     * IndexController constructor.
     * @param Banner $bannerModel
     * @param Config $configModel
     * @param Block $blockModel
     */
    public function __construct(
        Banner $bannerModel,
        Config $configModel,
        Block $blockModel,
        Voucher $voucherModel,
        Campaign $campaignModel,
        CampaignResult $campaignResultModel
    )
    {
        $this->bannerModel = $bannerModel;
        $this->configModel = $configModel;
        $this->blockModel = $blockModel;
        $this->voucherModel = $voucherModel;
        $this->campaignModel = $campaignModel;
        $this->campaignResultModel = $campaignResultModel;
        $this->page = 'index';
        $this->campaign = 'coupon-2022-08';
    }

    /**
     * Display a listing validate.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateFields($request) {

        $validator = Validator::make($request->all(), [
           'phoneNumber' => 'required|between:9,15|regex:/^[0-9]+$/',
        ], 
        [
            'phoneNumber.required'     => 'Điện thoại không được để trống',
            'phoneNumber.regex'        => 'Điện thoại không đúng định dạng', 
            'phoneNumber.between'      => 'Điện thoại phải từ 9 ký tự',  
        ]);

        return $validator; 
    }    
    // End validateFields 

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $this->seo()->setTitle($this->configModel::getConfig('meta_title'));
        $this->seo()->setDescription($this->configModel::getConfig('meta_description'));
        $this->seo()->metatags()->setKeywords(explode(',', $this->configModel::getConfig('meta_keyword')));
        $blocks = $this->blockModel::query()->where('block_status', 'activated')->where('block_campaign', 'LIKE', '%'.$this->campaign.'%')->where('block_page', $this->page)->get();
        $campaign = $this->campaignModel::query()->where('campaign_status', 'activated')->where('campaign_slug', 'LIKE', '%'.$this->campaign.'%')->first();
        // dd($blocks);
        return \view(
            $this->viewPath . 'page.'.$this->campaign.'.'.$this->page,
            [
                'blocks' => $blocks,
                'campaign' => $campaign
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getVoucher(Request $request)
    {
        $validateable = $this->validateFields($request);   
        if($validateable->fails())
        {
            return response()->json(['error'=>$validateable->errors()->all()]);
        }
        $data = $request->all();
        $errorMsg = 'Số điện thoại không hợp lệ';
        if(!empty($data['phoneNumber']) && $data['phoneNumber'] != '')
        {
            $phoneNumber = $this->campaignResultModel::query()->where('object_phone', $data['phoneNumber'])->first();
            if(empty($phoneNumber))
            {
                $campaign = $this->campaignModel::query()->where('campaign_status', 'activated')->where('campaign_slug', $this->campaign)->first();
                $voucherGroup = $campaign->voucher_group;
                $voucher = $this->voucherModel::query()->where('voucher_status', 'activated')->where('voucher_is_assigned', 'no')->inRandomOrder()->first();
                if(!empty($voucher))
                {
                    $voucherCode = $voucher->voucher_code;
                }
                else
                {
                    return response()->json(['error'=>'Rất tiếc, Lee&Tee đã tặng hết mã coupon. <b>Xin cám ơn khách hàng đã ủng hộ Lee&Tee. Hẹn bạn trong chương trình ưu đãi tiếp theo nhé</b>', 'voucherCode'=>'']);
                }

                // GET CAMPAIGN INFO
                $data['campaign'] = $campaign->campaign_id;
                $data['voucher'] = $voucher->voucher_id;
                $data['objectPhone'] = $data['phoneNumber'];
                // GET CLIENT INFO
                $agent                               = new Agent();
                $browser                             = $agent->browser();
                $versionBrowser                      = $agent->version($browser);
                $deviceType                          = $agent->deviceType();
                $platform                            = $agent->platform();
                $versionPlatform                     = $agent->version($platform);
                $ip                                  = $request->ip();

                $data['browser']                    = strip_tags($browser);
                $data['versionBrowser']             = strip_tags($versionBrowser);
                $data['deviceType']                 = strip_tags($deviceType);
                $data['platform']                   = strip_tags($platform);
                $data['versionPlatform']            = strip_tags($versionPlatform);
                $data['ip']                         = strip_tags($ip);

                $params = $this->campaignResultModel->revertAlias($data);
                $campaignResult = $this->campaignResultModel::query()->create($params);
                $this->voucherModel::query()->where('voucher_id', $voucher->voucher_id)->update(['voucher_is_assigned' => 'yes']);

                return response()->json(['success'=>'Cảm ơn quý khách. <b>Hãy sao chép coupon và mua hàng ngay. Chúc quý khách mua sắm vui vẻ tại Lee&Tee.</b>', 'voucherCode'=>$voucherCode]);
            }
            else
            {
                $campaign = $this->campaignModel::query()->where('campaign_status', 'activated')->where('campaign_slug', $this->campaign)->first();
                $campaignResult = $this->campaignResultModel::query()->where('campaign_id', $campaign->campaign_id)->where('object_phone', $data['phoneNumber'])->first();
                $voucherId = $campaignResult->voucher_id;
                $voucher = $this->voucherModel::find($voucherId);
                $voucherCode = $voucher->voucher_code;
                return response()->json(['error'=>'Số điện thoại đã sử dụng. <b>Hệ thống lấy mã coupon khách hàng đã nhận. Hãy sao chép coupon và mua hàng ngay.</b>', 'voucherCode'=>$voucherCode]);
            }
        }
        else
        {
            return response()->json(['error'=>$errorMsg, 'voucherCode'=>'']);
        }
        // dd($data);
    }
}
