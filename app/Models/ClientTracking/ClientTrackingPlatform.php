<?php

namespace App\Models\ClientTracking;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClientTrackingPlatform extends BaseModel
{
    use HasFactory;
    protected $table    = CLIENTTRACKING_TRACKINGPLATFORM_TBL;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'icon',
        'is_delete',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    const ALIAS = [
        'id'          => 'id',
        'created_at'  => 'createdAt',
        'updated_at'  => 'updatedAt',
        'created_by'  => 'createdBy',
        'updated_by'  => 'updatedBy',
        'deleted_by'  => 'deletedBy',
        'name'        => 'name',
        'icon'        => 'icon',
        'status'      => 'status',
        'is_delete'   => 'isDelete',
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
    public function scopeNotDeleted($query)
    {
        return $query->where('is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('status', 'activated');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDesc($query)
    {
        return $query->orderby('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'report_id')
            ->where(['3rd_type' => 'clientTrackingPlatform', 'image_value' => config('my.image.value.clientTrackingPlatform.avatar'), 'image_status' => 'activated']);
    }
}
