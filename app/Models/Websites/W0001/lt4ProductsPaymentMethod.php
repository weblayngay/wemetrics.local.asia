<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4ProductsPaymentMethod extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_PAYMENT_METHOD;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'class_name',
        'description',
        'created',
        'created_by',
        'enable',
        'payment_default',
        'ordering',
    ];

    const ALIAS = [
        'id'                => 'id',
        'name'              => 'name',
        'type'              => 'type',
        'class_name'        => 'className',
        'description'       => 'description',
        'created'           => 'created',
        'created_by'        => 'createdBy',
        'enable'            => 'id',
        'payment_default'   => 'paymentDefault',
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
