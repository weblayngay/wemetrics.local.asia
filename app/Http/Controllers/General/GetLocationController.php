<?php

namespace App\Http\Controllers\General;

use App\Models\Ward;
use App\Models\Province;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GetLocationController extends BaseController
{
    private $wardModel;
    private $provinceModel;
    private $districtModel;

    public function __construct()
    {
        $this->wardModel = new Ward();
        $this->provinceModel = new Province();
        $this->districtModel = new District();
    }

    /**
     * @param Request $request
     */
    public function getDistrict(Request $request){
        $id = $request->id;
        $data = $this->districtModel::query()->where('province_id', $id)->get();

        $html = '<option value="">Chọn</option>';
        if(!empty($data)){
            foreach ($data as $key => $item){
                $html .= '<option value="' . $item->id . '">'. $item->name . '</option>';
            }
        }

        $response = [
            'html' => $html,
        ];
        return json_encode($response);
    }

    /**
     * @param Request $request
     */
    public function getWard(Request $request){
        $id = $request->id;
        $data = $this->wardModel::query()->where('district_id', $id)->get();

        $html = '<option value="">Chọn</option>';
        if(!empty($data)){
            foreach ($data as $key => $item){
                $html .= '<option value="' . $item->id . '">'. $item->name . '</option>';
            }
        }

        $response = [
            'html' => $html,
        ];
        return json_encode($response);
    }
}
