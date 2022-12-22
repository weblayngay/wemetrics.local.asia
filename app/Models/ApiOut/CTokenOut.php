<?php

namespace App\Models\ApiOut;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CTokenOut extends BaseModel
{
    use HasFactory;
    protected $table    = CTOKENOUT_TBL;
    protected $primaryKey = 'ctokenout_id';
    const CREATED_AT = 'ctokenout_created_at';
    const UPDATED_AT = 'ctokenout_updated_at';
    const EXPIRED_AT = 'ctokenout_expired_at';

    protected $fillable = [
        'ctokenout_id',
        'ctokenout_created_at',
        'ctokenout_updated_at',
        'ctokenout_created_by',
        'ctokenout_updated_by',
        'ctokenout_deleted_by',

        //vi
        'ctokenout_name',
        'ctokenout_value',
        'ctokenout_vendor',
        'ctokenout_status',
        'ctokenout_is_delete',
    ];

    const ALIAS = [
        'ctokenout_id'               => 'id',
        'ctokenout_created_at'       => 'createdAt',
        'ctokenout_updated_at'       => 'updateAt',
        'ctokenout_created_by'       => 'createdBy',
        'ctokenout_updated_by'       => 'updatedBy',
        'ctokenout_deleted_by'       => 'deletedBy',
        'ctokenout_name'             => 'name',
        'ctokenout_value'            => 'value',
        'ctokenout_vendor'           => 'vendor',
        'ctokenout_status'           => 'status',
        'ctokenout_is_delete'        => 'isDelete',
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
        return $query->orderby('ctokenout_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('ctokenout_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('ctokenout_status', 'activated');
    }

    /**
     * @return BelongsTo
     */
    public function ctokenvendors(): BelongsTo
    {
        return $this->belongsTo('App\Models\CTokenVendor', 'vendor_id', 'ctokenout_vendor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('ctokenout_status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'ctokenout_id')
            ->where(['3rd_type' => 'ctokenout', 'image_value' => config('my.image.value.ctokenout.avatar'), 'image_status' => 'activated']);
    }
}
