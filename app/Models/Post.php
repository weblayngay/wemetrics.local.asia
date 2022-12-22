<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends BaseModel
{
    use HasFactory;
    protected $table    = POST_TBL;
    protected $primaryKey = 'post_id';
    const CREATED_AT = 'post_created_at';
    const UPDATED_AT = 'post_updated_at';

    protected $fillable = [
        'post_id',
        'post_created_at',
        'post_updated_at',
        'post_created_by',
        'post_updated_by',
        'post_deleted_by',
        'post_group',

        //vi
        'post_name',
        'post_description',
        'post_content',
        'post_status',
        'post_slug',
        'post_url',
        'post_meta_title',
        'post_meta_keywords',
        'post_meta_description',
        'post_is_delete',
        'post_is_hot',
        'post_is_view',
        'post_is_new',
        'post_related',
        'post_category',

        //en
        'post_name_en',
        'post_description_en',
        'post_content_en',
        'post_url_en',
        'post_meta_title_en',
        'post_meta_keywords_en',
        'post_meta_description_en'
    ];

    const ALIAS = [
        'post_id'               => 'id',
        'post_created_at'       => 'createdAt',
        'post_updated_at'       => 'updatedAt',
        'post_created_by'       => 'createdBy',
        'post_updated_by'       => 'updatedBy',
        'post_deleted_by'       => 'deletedBy',
        'post_group'            => 'group',

        //vi
        'post_name'             => 'name',
        'post_description'      => 'description',
        'post_content'          => 'content',
        'post_status'           => 'status',
        'post_slug'             => 'slug',
        'post_url'              => 'url',
        'post_meta_title'       => 'metaTitle',
        'post_meta_keywords'    => 'metaKeywords',
        'post_meta_description' => 'metaDescription',
        'post_is_delete'        => 'isDelete',
        'post_is_hot'           => 'isHot',
        'post_is_view'          => 'isView',
        'post_is_new'           => 'isNew',
        'post_related'          => 'related',
        'post_category'         => 'category',

        //en
        'post_name_en'          => 'nameEn',
        'post_description_en'   => 'descriptionEn',
        'post_content_en'       => 'contentEn',
        'post_url_en'           => 'urlEn',
        'post_meta_title_en'    => 'metaTitleEn',
        'post_meta_keywords_en' => 'metaKeywordsEn',
        'post_meta_description_en' => 'metaDescriptionEn',
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
        return $query->where('post_is_delete', 'no');
    }

    /**
     * @return BelongsTo
     */
    public function groups(): BelongsTo
    {
        return $this->belongsTo('App\Models\PostGroup', 'postgroup_id', 'post_group');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'post_id')
            ->where(['3rd_type' => 'post', 'image_value' => config('my.image.value.post.avatar'), 'image_status' => 'activated']);
    }
}
