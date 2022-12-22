<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4ProductsOrdersDetail extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_ORDERS_DETAIL;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'pid',
        'name',
        'price',
        'quantity',
        'color',
        'total_price',
        'rid',
    ];

    const ALIAS = [
        'order_id'      => 'orderId',
        'pid'           => 'pid',
        'name'          => 'name',
        'price'         => 'price',
        'quantity'      => 'quantity',
        'color'         => 'color',
        'total_price'   => 'totalPrice',
        'rid'           => 'rid',
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
