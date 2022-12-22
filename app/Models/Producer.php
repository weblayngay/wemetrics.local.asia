<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Producer extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCER_TBL;
    protected $primaryKey = 'producer_id';
    const CREATED_AT = 'producer_created_at';
    const UPDATED_AT = 'producer_updated_at';

    protected $fillable = [
        'producer_id',
        'producer_created_at',
        'producer_updated_at',
        'producer_created_by',
        'producer_updated_by',
        'producer_deleted_by',

        //vi
        'producer_name',
        'producer_code',
        'producer_slug',
        'producer_description',
        'producer_content',
        'producer_status',
        'producer_meta_title',
        'producer_meta_keywords',
        'producer_meta_description',
        'producer_is_delete',
        'producer_type',
        'producer_sorted',
    ];

    const ALIAS = [
        'producer_id'               => 'id',
        'producer_created_at'       => 'createdAt',
        'producer_updated_at'       => 'updatedAt',
        'producer_created_by'       => 'createdBy',
        'producer_updated_by'       => 'updatedBy',
        'producer_deleted_by'       => 'deletedBy',

        //vi
        'producer_name'             => 'name',
        'producer_code'             => 'code',
        'producer_slug'             => 'slug',
        'producer_description'      => 'description',
        'producer_content'          => 'content',
        'producer_status'           => 'status',
        'producer_meta_title'       => 'metaTitle',
        'producer_meta_keywords'    => 'metaKeywords',
        'producer_meta_description' => 'metaDescription',
        'producer_is_delete'        => 'isDelete',
        'producer_type'             => 'type',
        'producer_sorted'           => 'sorted',
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
    static function query()
    {
        return parent::query()->notDeleted();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('producer_is_delete', 'no');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'producer_id')
            ->where(['3rd_type' => 'producer', 'image_value' => config('my.image.value.producer.avatar'), 'image_status' => 'activated']);
    }
}
