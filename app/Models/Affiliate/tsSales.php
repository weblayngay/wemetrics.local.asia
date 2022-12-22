<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsSales extends BaseModel
{
    use HasFactory;

    protected $table = TS_SALES;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'afid',
        'ordernum',
        'prv_id',
        'amount',
        'comm_percent',
        'comm_amount',
        'bonus',
        'approved',
        'paid',
        'payid',
        'adid',
        'tranfer',
        'autoappr',
        'ref_url',
        'created',
        'recievedate',
        'ip',
    ];

    const ALIAS = [
        'afid'          => 'afid',
        'ordernum'      => 'ordernum',
        'prv_id'        => 'prv_id',
        'amount'        => 'amount',
        'comm_percent'  => 'comm_percent',
        'comm_amount'   => 'comm_amount',
        'bonus'         => 'bonus',
        'approved'      => 'approved',
        'paid'          => 'paid',
        'payid'         => 'payid',
        'adid'          => 'adid',
        'tranfer'       => 'tranfer',
        'autoappr'      => 'autoappr',
        'ref_url'       => 'ref_url',
        'created'       => 'created',
        'recievedate'   => 'recievedate',
        'ip'            => 'ip',
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsApproved($query)
    {
        return $query
        ->where('approved', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotApproved($query)
    {
        return $query
        ->where('approved', '0');
    }
}
