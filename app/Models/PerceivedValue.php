<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PerceivedValue extends BaseModel
{
    use HasFactory;

    protected $table = PERCEIVED_VALUE_TBL;
    protected $primaryKey = 'pervalue_id';
    const CREATED_AT = 'pervalue_created_at';
    const UPDATED_AT = 'pervalue_updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'pervalue_is_delete',
        'pervalue_created_by',
        'pervalue_updated_by',
        'pervalue_deleted_by',
        'pervalue_created_at',
        'pervalue_updated_at',

        //vi
        'pervalue_description',
        'pervalue_fullname',
        'pervalue_status',
        'pervalue_sorted'
    ];

    const ALIAS = [
        'pervalue_id' => 'id',
        'pervalue_description' => 'description',
        'pervalue_fullname' => 'fullname',
        'pervalue_status' => 'status',
        'pervalue_is_delete' => 'delete',
        'pervalue_created_by' => 'createdBy',
        'pervalue_updated_by' => 'updatedBy',
        'pervalue_deleted_by' => 'deletedBy',
        'pervalue_created_at' => 'createdAt',
        'pervalue_updated_at' => 'updateAt',
        'pervalue_sorted' => 'sorted',

    ];

    /**
     * @return Builder
     */
    static function parentQuery()
    {
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
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('pervalue_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('pervalue_status', 'activated');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'pervalue_id')
            ->where(['3rd_type' => 'perceivedvalue', 'image_value' => config('my.image.value.pervalue.avatar'), 'image_status' => 'activated']);
    }
}
