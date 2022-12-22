<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use App\Models\Websites\W0001\lt4Order;
use App\Models\Voucher;

class CampaignResult extends BaseModel
{
    use HasFactory;
    protected $table    = CAMPAIGN_RESULT_TBL;
    protected $primaryKey = 'campaignresult_id';
    const CREATED_AT = 'campaignresult_created_at';
    const UPDATED_AT = 'campaignresult_updated_at';

    protected $fillable = [
        'campaignresult_id',
        'campaignresult_created_at',
        'campaignresult_update_at',
        
        //vi
        'voucher_id',
        'campaign_id',
        'object_name',
        'object_email',
        'object_phone',
        'browser',
        'versionBrowser',
        'deviceType',
        'platform',
        'versionPlatform',
        'ip',

    ];

    const ALIAS = [
        'campaignresult_id'               => 'id',
        'campaignresult_created_at'       => 'createdAt',
        'campaignresult_update_at'        => 'updatedAt',
        //vi
        'voucher_id'    => 'voucher',
        'campaign_id'   => 'campaign',
        'object_name'   => 'objectName',
        'object_email'  => 'objectEmail',
        'object_phone'  => 'objectPhone',
        'browser'       => 'browser',
        'versionBrowser'=> 'versionBrowser',
        'deviceType'    => 'deviceType',
        'platform'      => 'platform',
        'versionPlatform' => 'versionPlatform',
        'ip'            => 'ip',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query()
    {
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query2nd()
    {
        $result = DB::table(CAMPAIGN_RESULT_TBL. ' as t1')
                ->leftjoin(CAMPAIGN_TBL.' as t2', 't1.campaign_id', '=', 't2.campaign_id')
                ->leftjoin(VOUCHER_TBL.' as t3', 't1.voucher_id', '=', 't3.voucher_id')
                ->select('t1.*', 't2.campaign_name as campaign_name', 't3.voucher_code as voucher_code', 't3.voucher_is_used as voucher_is_used')
                ->orderby('t1.campaignresult_id', 'desc')
                ->limit(QUERY_LIMIT)
                ->get();
                
        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $campaign, $voucher, $isUsed, $paginateNum)
    {
        $result = DB::table(CAMPAIGN_RESULT_TBL. ' as t1')
                ->leftjoin(CAMPAIGN_TBL.' as t2', 't1.campaign_id', '=', 't2.campaign_id')
                ->leftjoin(VOUCHER_TBL.' as t3', 't1.voucher_id', '=', 't3.voucher_id')
                ->select('t1.*', 't2.campaign_name as campaign_name', 't3.voucher_code as voucher_code', 't3.voucher_is_used as voucher_is_used')
                ->where($column, 'LIKE', '%'.$searchStr.'%')
                ->where('t2.campaign_id', 'LIKE', '%'.$campaign.'%')
                ->where('t3.voucher_code', 'LIKE', '%'.$voucher.'%')
                ->where('t3.voucher_is_used', 'LIKE', '%'.$isUsed.'%')
                ->orderby('t1.campaignresult_id', 'desc')
                ->get();

        return $result;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDesc($query)
    {
        return $query->orderby('campaignresult_id', 'desc');
    }

    /**
     * @return BelongsTo
     */
    public function campaign()
    {
        return parent::belongsTo('App\Models\Campaign', 'campaign_id', 'campaign_id');
    }

    /**
     * @return BelongsTo
     */
    public function voucher()
    {
        return parent::belongsTo('App\Models\Voucher', 'voucher_id', 'voucher_id');
    }
}
