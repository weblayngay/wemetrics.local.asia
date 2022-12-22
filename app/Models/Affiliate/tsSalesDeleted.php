<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsSalesDeleted extends BaseModel
{
    use HasFactory;

    protected $table = TS_SALES_DELETED;
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
        'deleted_by',
        'deleted_date',
        'reason',
        'note',
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
        'deleted_by'    => 'deleted_by',
        'deleted_date'  => 'deleted_date',
        'reason'        => 'reason',
        'note'          => 'note',
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
