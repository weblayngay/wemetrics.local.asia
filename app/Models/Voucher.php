<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use DB;

class Voucher extends BaseModel
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table    = VOUCHER_TBL;
    protected $primaryKey = 'voucher_id';
    const CREATED_AT = 'voucher_created_at';
    const UPDATED_AT = 'voucher_updated_at';
    const EXPIRED_AT = 'voucher_expired_at';

    protected $fillable = [
        'voucher_id',
        'voucher_type',
        'voucher_created_at',
        'voucher_updated_at',
        'voucher_began_at',
        'voucher_expired_at',
        'voucher_created_by',
        'voucher_updated_by',
        'voucher_deleted_by',

        //vi
        'voucher_name',
        'voucher_description',
        'voucher_group',
        'voucher_code',
        'voucher_percent',
        'voucher_cost',
        'voucher_status',
        // 'voucher_is_used',
        'voucher_is_assigned',
        'voucher_is_delete',
    ];

    const ALIAS = [
        'voucher_id'               => 'id',
        'voucher_type'             => 'type',
        'voucher_created_at'       => 'createdAt',
        'voucher_updated_at'       => 'updateAt',
        'voucher_began_at'         => 'beganAt',
        'voucher_expired_at'       => 'expiredAt',
        'voucher_created_by'       => 'createdBy',
        'voucher_updated_by'       => 'updatedBy',
        'voucher_deleted_by'       => 'deletedBy',
        'voucher_name'             => 'name',
        'voucher_description'      => 'description',
        'voucher_group'            => 'group',
        'voucher_code'             => 'code',
        'voucher_percent'          => 'percent',
        'voucher_cost'             => 'cost',
        'voucher_status'           => 'status',
        // 'voucher_is_used'          => 'isUsed',
        'voucher_is_assigned'      => 'isAssigned',
        'voucher_is_delete'        => 'isDelete',
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
    static function query($isDeleted = true)
    {
        if($isDeleted == true)
        {
            return parent::query()->notDeleted();
        } else {
            return parent::query();
        }
        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query2nd($isDeleted = true)
    {
        if($isDeleted == true)
        {
            return parent::query()->notDeleted()->limit(QUERY_LIMIT)->get();
        } else {
            return parent::query()->limit(QUERY_LIMIT)->get();
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDesc($query)
    {
        return $query->orderby('voucher_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('voucher_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('voucher_status', 'activated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $group, $isUsed, $isAssigned, $status, $paginateNum)
    {
        $result = DB::table(VOUCHER_TBL. ' as t1')
                ->select('t1.*')
                ->where($column, 'LIKE', '%'.$searchStr.'%')
                ->where('t1.voucher_group', 'LIKE', '%'.$group.'%')
                ->where('t1.voucher_is_used', 'LIKE', '%'.$isUsed.'%')
                ->where('t1.voucher_is_assigned', 'LIKE', '%'.$isAssigned.'%')
                ->where('t1.voucher_status', 'LIKE', '%'.$status.'%')
                ->orderby('t1.voucher_id', 'desc')
                ->get();

        return $result;
    }

    /**
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Models\VoucherGroup', 'vouchergroup_id', 'voucher_group');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'voucher_id')
            ->where(['3rd_type' => 'voucher', 'image_value' => config('my.image.value.voucher.avatar'), 'image_status' => 'activated']);
    }

    /**
     * @return HasMany
     */
    public function campaignResults(): HasMany
    {
        return $this->HasMany('App\Models\CampaignResult', 'voucher_id', 'voucher_id');
    }

    /*
    |-------------------------------------------------------
    | INTERGRATE WITH CORE WEBSITE
    |-------------------------------------------------------
    */

    /**
     * @return HasMany
     */
    public function intergrateOrders(): HasMany
    {
        return $this->HasMany('App\Models\Websites\W0001\lt4Order', 'vcode', 'voucher_code');
    }
}
