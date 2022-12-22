<?php

namespace App\Models\ClientTracking;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClientTrackingGeoLiteDetails extends BaseModel
{
    use HasFactory;
    protected $table    = CLIENTTRACKING_GEOLITEDETAILS_TBL;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'client_id',
        'ip',
        'city',
        'city_geoname_id',
        'region',
        'region_iso_code',
        'region_geoname_id',
        'postal_code',
        'country',
        'country_code',
        'continent',
        'continent_code',
        'continent_geoname_id',
        'longitude',
        'latitude',
        'is_vpn',
        'created_at',
        'updated_at',
    ];

    const ALIAS = [
        'id'                    => 'id',
        'client_id'             => 'clientId',
        'created_at'            => 'createdAt',
        'updated_at'            => 'updatedAt',
        'ip'                    => 'ip',
        'city'                  => 'city',
        'city_geoname_id'       => 'cityId',
        'region'                => 'region',
        'region_iso_code'       => 'regionCode',
        'region_geoname_id'     => 'regionId',
        'postal_code'           => 'postalCode',
        'country'               => 'country',
        'country_code'          => 'countryCode',
        'continent'             => 'continent',
        'continent_code'        => 'continentCode',
        'continent_geoname_id'  => 'continentId',
        'longitude'             => 'longitude',
        'latitude'              => 'latitude',
        'is_vpn'                => 'isVpn',
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
            ->where(['3rd_type' => 'clientTrackingGeoLiteDetails', 'image_value' => config('my.image.value.clientTrackingGeoLiteDetails.avatar'), 'image_status' => 'activated']);
    }
}
