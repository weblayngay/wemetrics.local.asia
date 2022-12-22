<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends BaseModel
{
    use HasFactory;
    protected $table    = ORDER_ITEM_TBL;
    protected $primaryKey = 'ordi_id';
    const CREATED_AT = 'ordi_created_at';
    const UPDATED_AT = 'ordi_updated_at';

    protected $fillable = [
        'ordi_id',
        'ordi_historical_cost',
        'ordi_quantity',
        'ordi_total_cost',
        'ordi_updated_at',
        'ordi_created_at',
        'ordi_is_deleted',
        'user_id',
        'product_id',
        'pcolor_id',
        'psize_id',
        'ord_id',
    ];

    const ALIAS = [
        'ordi_historical_cost'      => 'historicalCost',
        'ordi_quantity'             => 'quantity',
        'ordi_total_cost'           => 'totalCost',
        'ordi_updated_at'           => 'updatedAt',
        'ordi_created_at'           => 'createdAt',
        'ordi_is_deleted'           => 'isDeleted',
        'user_id'                   => 'userId',
        'product_id'                => 'productId',
        'pcolor_id'                 => 'pcolorId',
        'psize_id'                  => 'psizeId',
        'ord_id'                    => 'ordId',
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
        return parent::query()->notDeleted();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('ordi_is_deleted', 'no');
    }
}
