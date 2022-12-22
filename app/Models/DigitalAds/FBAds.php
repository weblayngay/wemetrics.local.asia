<?php

namespace App\Models\DigitalAds;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FBAds extends BaseModel
{
    use HasFactory;
    protected $table    = FBADS_TBL;
    protected $primaryKey = 'report_id';
    const CREATED_AT = 'report_created_at';
    const UPDATED_AT = 'report_updated_at';
    const EXPIRED_AT = 'report_expired_at';

    protected $fillable = [
        'report_id',
        'report_url',
        'report_created_at',
        'report_updated_at',
        'report_created_by',
        'report_updated_by',
        'report_deleted_by',

        //vi
        'report_name',
        'report_status',
        'report_is_delete',
    ];

    const ALIAS = [
        'report_id'               => 'id',
        'report_url'              => 'url',
        'report_created_at'       => 'createdAt',
        'report_updated_at'       => 'updatedAt',
        'report_created_by'       => 'createdBy',
        'report_updated_by'       => 'updatedBy',
        'report_deleted_by'       => 'deletedBy',
        'report_name'             => 'name',
        'report_status'           => 'status',
        'report_is_delete'        => 'isDelete',
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
        return $query->orderby('report_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('report_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('report_status', 'activated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('report_status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'report_id')
            ->where(['3rd_type' => 'fbads', 'image_value' => config('my.image.value.fbads.avatar'), 'image_status' => 'activated']);
    }
}
