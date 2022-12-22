<?php

namespace App\Models\ClientTracking;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClientTrackingTrafficAds extends BaseModel
{
    use HasFactory;
    protected $table    = CLIENTTRACKING_TRAFFICADS_TBL;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'client_id',
        'browser',
        'version_browser',
        'device_type',
        'platform',
        'version_platform',
        'ip',
        'request_rui',
        'referer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'created_at',
        'updated_at',
    ];

    const ALIAS = [
        'id'                => 'id',
        'created_at'        => 'createdAt',
        'updated_at'        => 'updatedAt',
        'client_id'         => 'clientId',
        'browser'           => 'browser',
        'version_browser'   => 'versionBrowser',
        'device_type'       => 'deviceType',
        'platform'          => 'platform',
        'version_platform'  => 'versionPlatform',
        'ip'                => 'ip',
        'request_rui'       => 'requestRui',
        'referer'           => 'referer',
        'utm_source'        => 'utmSource',
        'utm_medium'        => 'utmMedium',
        'utm_campaign'      => 'utmCampaign',
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
    static function query($isDeleted = true)
    {
        return parent::query()->OrderByDesc();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDesc($query)
    {
        return $query->orderby('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'report_id')
            ->where(['3rd_type' => 'clientTrackingTrafficAds', 'image_value' => config('my.image.value.clientTrackingTrafficAds.avatar'), 'image_status' => 'activated']);
    }
}
