<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4ProductsShippingCities extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_SHIPPING_CITIES;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_name',
        'required_num_id',
        'suburban',
        'enable',
        'ordering',
    ];

    const ALIAS = [
        'city_name'         => 'cityName',
        'required_num_id'   => 'requiredNumId',
        'suburban'          => 'suburban',
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
}
