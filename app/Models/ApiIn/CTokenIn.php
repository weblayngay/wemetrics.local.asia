<?php

namespace App\Models\ApiIn;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CTokenIn extends BaseModel
{
    use HasFactory;
    protected $table    = CTOKENIN_TBL;
    protected $primaryKey = 'ctokenin_id';
    const CREATED_AT = 'ctokenin_created_at';
    const UPDATED_AT = 'ctokenin_updated_at';
    const EXPIRED_AT = 'ctokenin_expired_at';

    protected $fillable = [
        'ctokenin_id',
        'client_id',
        'client_key',
        'ctokenin_created_at',
        'ctokenin_updated_at',
        'ctokenin_created_by',
        'ctokenin_updated_by',
        'ctokenin_deleted_by',

        //vi
        'ctokenin_name',
        'ctokenin_status',
        'ctokenin_is_delete',
    ];

    const ALIAS = [
        'ctokenin_id'               => 'id',
        'client_id'                 => 'clientId',
        'client_key'                => 'clientKey',
        'ctokenin_created_at'       => 'createdAt',
        'ctokenin_updated_at'       => 'updateAt',
        'ctokenin_created_by'       => 'createdBy',
        'ctokenin_updated_by'       => 'updatedBy',
        'ctokenin_deleted_by'       => 'deletedBy',
        'ctokenin_name'             => 'name',
        'ctokenin_status'           => 'status',
        'ctokenin_is_delete'        => 'isDelete',
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
        return $query->orderby('ctokenin_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('ctokenin_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('ctokenin_status', 'activated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('ctokenin_status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'ctokenin_id')
            ->where(['3rd_type' => 'ctokenin', 'image_value' => config('my.image.value.ctokenin.avatar'), 'image_status' => 'activated']);
    }
}
