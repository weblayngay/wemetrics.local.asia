<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsOrderItems extends BaseModel
{
    use HasFactory;

    protected $table = TS_ORDER_ITEMS;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
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
        'qty',
        'total',
    ];

    const ALIAS = [
        'order_id'  => 'order_id',
        'pid'       => 'pid',
        'name'      => 'name',
        'price'     => 'price',
        'qty'       => 'qty',
        'total'     => 'total',
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
