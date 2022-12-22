<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsPayments extends BaseModel
{
    use HasFactory;

    protected $table = TS_PAYMENTS;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    const PAYMENT = [
        '1'    => 'Tiền mặt',
        '2'    => 'Chuyển khoản',
    ];

    const PAYMENT_COLOR = [
        '1'    => 'primary',
        '2'    => 'secondary',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'afid',
        'amount',
        'created',
        'paid',
        'payby',
        'paydate',
        'adnote',
        'pmethod',
    ];

    const ALIAS = [
        'afid'      => 'afid',
        'amount'    => 'amount',
        'created'   => 'created',
        'paid'      => 'paid',
        'payby'     => 'payby',
        'paydate'   => 'paydate',
        'adnote'    => 'adnote',
        'pmethod'   => 'pmethod',
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
    public function scopeIsPaid($query)
    {
        return $query
        ->where('paid', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotPaid($query)
    {
        return $query
        ->where('paid', '0');
    }
}
