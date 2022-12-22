<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class VoucherGroup extends BaseModel
{
    use HasFactory;
    protected $table    = VOUCHER_GROUP_TBL;
    protected $primaryKey = 'vouchergroup_id';
    const CREATED_AT = 'vouchergroup_created_at';
    const UPDATED_AT = 'vouchergroup_updated_at';

    protected $fillable = [
        'vouchergroup_id',
        'vouchergroup_created_at',
        'vouchergroup_update_at',
        'vouchergroup_created_by',
        'vouchergroup_updated_by',
        'vouchergroup_deleted_by',
        
        //vi
        'vouchergroup_name',
        'vouchergroup_status',
        'vouchergroup_description',
        'vouchergroup_is_delete',
        'vouchergroup_parent',

    ];

    const ALIAS = [
        'vouchergroup_id'               => 'id',
        'vouchergroup_created_at'       => 'createdAt',
        'vouchergroup_update_at'        => 'updatedAt',
        'vouchergroup_created_by'       => 'createdBy',
        'vouchergroup_updated_by'       => 'updatedBy',
        'vouchergroup_deleted_by'       => 'deletedBy',
        //vi
        'vouchergroup_name'             => 'name',
        'vouchergroup_status'           => 'status',
        'vouchergroup_description'      => 'description',
        'vouchergroup_is_delete'        => 'isDelete',
        'vouchergroup_parent'           => 'parent',
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
            return parent::query()->notDeleted()->OrderByDesc();
        } else {
            return parent::query()->OrderByDesc();
        }
        
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDesc($query)
    {
        return $query->orderby('vouchergroup_id', 'desc');
    }

     /**
     * @return hasMany
     */
     public function items()
     {
        return $this->hasMany(self::class, 'vouchergroup_parent');
     }

     /**
     * @return hasMany
     */
     public function childItems()
     {
        return $this->hasMany(self::class, 'vouchergroup_parent')->with('items');
     }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('vouchergroup_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('vouchergroup_status', 'activated');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsParent($query)
    {
        return $query->where('vouchergroup_parent', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotParent($query)
    {
        return $query->where('vouchergroup_parent', '<>', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $isUsed, $paginateNum)
    {
        $result = DB::table(VOUCHER_GROUP_TBL. ' as t1')
                ->leftjoin(VOUCHER_TBL.' as t2', 't1.vouchergroup_id', '=', 't2.voucher_group')
                ->select('t1.*', DB::raw('CASE WHEN t2.voucher_id != "" THEN "yes" ELSE "no" END AS vouchergroup_used'))
                ->where($column, 'LIKE', '%'.$searchStr.'%')
                ->where(DB::raw('CASE WHEN t2.voucher_id != "" THEN "yes" ELSE "no" END'), 'LIKE', '%'.$isUsed.'%')
                ->where('t1.vouchergroup_status', 'LIKE', '%'.$status.'%')
                ->orderby('t1.vouchergroup_id', 'desc')
                ->get();

        return $result;
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'vouchergroup_id')
            ->where(['3rd_type' => 'vouchergroup', 'image_value' => config('my.image.value.vouchergroup.avatar'), 'image_status' => 'activated']);
    }

    /**
     * @return HasMany
     */
    public function vouchers(): HasMany
    {
        return parent::HasMany('App\Models\Voucher', 'vouchergroup_id', 'voucher_group');
    }
}
