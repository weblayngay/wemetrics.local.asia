<?php

namespace App\Http\Controllers\Backend\ClientTracking;

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
use App\Models\ClientTracking\ClientTrackingUtmMedium;
use App\Models\ClientTracking\ClientTrackingUtmCampaign;
use App\Models\ClientTracking\ClientTrackingUtmSource;

class UtmcreatorController extends BaseController
{
    private $view = '.utmcreator';
    private $utmsourceModel;
    private $utmcampaignModel;
    private $utmmediumModel;
    public function __construct()
    {
        $this->utmsourceModel = new ClientTrackingUtmSource();
        $this->utmmediumModel = new ClientTrackingUtmMedium();
        $this->utmcampaignModel = new ClientTrackingUtmCampaign();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CLIENTTRACKING_UTMCAMPAIGN_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.index';
        $data['sources'] = $this->utmsourceModel::query()->select('id','name')->IsActivated()->get();
        $data['mediums'] = $this->utmmediumModel::query()->select('id','name')->IsActivated()->get();
        $data['campaigns'] = $this->utmcampaignModel::query()->select('id','name')->IsActivated()->get();
        return view($data['view'] , compact('data'));
    }
}