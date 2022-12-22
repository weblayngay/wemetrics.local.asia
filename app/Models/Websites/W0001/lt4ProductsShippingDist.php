<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4ProductsShippingDist extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_SHIPPING_DIST;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dist_name',
        'type',
        'city_id',
        'enable',
        'ordering',
    ];

    const ALIAS = [
        'dist_name'         => 'distName',
        'type'              => 'type',
        'city_id'           => 'cityId',
        'enable'            => 'enable',
        'ordering'          => 'ordering',
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('enable', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsWard($query)
    {
        return $query->where('type', '<>', 'Quận');
    }     

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsDistrict($query)
    {
        return $query->where('type', '=', 'Quận');
    }                  
}
