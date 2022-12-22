<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4ProductsOrdersUserInfo extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_ORDERS_USER_INFO;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'name',
        'id_num',
        'address',
        'city_name',
        'dist_name',
        'city_id',
        'dist_id',
        'email',
        'phone',
        'gf_name',
        'gf_address',
        'gf_phone',
        'gf_email',
        'gf_city_id',
        'gf_dist_id',
        'gf_city_name',
        'gf_dist_name',
        'gf_note',
        'created',
    ];

    const ALIAS = [
        'uid'           => 'uid',
        'name'          => 'name',
        'id_num'        => 'idNum',
        'address'       => 'address',
        'city_name'     => 'cityName',
        'dist_name'     => 'distName',
        'city_id'       => 'cityId',
        'dist_id'       => 'distId',
        'email'         => 'email',
        'phone'         => 'phone',
        'gf_name'       => 'gfName',
        'gf_address'    => 'gfAddress',
        'gf_phone'      => 'gfPhone',
        'gf_email'      => 'gfEmail',
        'gf_city_id'    => 'gfCityId',
        'gf_dist_id'    => 'gfDistId',
        'gf_city_name'  => 'gfCityName',
        'gf_dist_name'  => 'gfDistName',
        'gf_note'       => 'gfNote',
        'created'       => 'created',
    ];

    /**
     * @return Builder
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
}
