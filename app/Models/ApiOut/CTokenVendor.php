<?php

namespace App\Models\ApiOut;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class CTokenVendor extends BaseModel
{
    use HasFactory;
    protected $table    = CTOKENVENDOR_TBL;
    protected $primaryKey = 'vendor_id';
    const CREATED_AT = 'vendor_created_at';
    const UPDATED_AT = 'vendor_updated_at';

    protected $fillable = [
        'vendor_id',
        'vendor_created_at',
        'vendor_update_at',
        'vendor_created_by',
        'vendor_updated_by',
        'vendor_deleted_by',
        
        //vi
        'vendor_name',
        'vendor_status',
        'vendor_description',
        'vendor_is_delete',
    ];

    const ALIAS = [
        'vendor_id'               => 'id',
        'vendor_created_at'       => 'createdAt',
        'vendor_update_at'        => 'updatedAt',
        'vendor_created_by'       => 'createdBy',
        'vendor_updated_by'       => 'updatedBy',
        'vendor_deleted_by'       => 'deletedBy',
        //vi
        'vendor_name'             => 'name',
        'vendor_status'           => 'status',
        'vendor_description'      => 'description',
        'vendor_is_delete'        => 'isDelete',
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
        return $query->orderby('vendor_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('vendor_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('vendor_status', 'activated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('vendor_status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return HasMany
     */
    public function ctokenouts(): HasMany
    {
        return parent::HasMany('App\Models\CTokenOut', 'ctokenout_vendor', 'vendor_id');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'vendor_id')
            ->where(['3rd_type' => 'ctokenvendor', 'image_value' => config('my.image.value.ctokenvendor.avatar'), 'image_status' => 'activated']);
    }
}
