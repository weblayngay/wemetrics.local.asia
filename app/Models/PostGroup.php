<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostGroup extends BaseModel
{
    use HasFactory;
    protected $table    = POST_GROUP_TBL;
    protected $primaryKey = 'postgroup_id';
    const CREATED_AT = 'postgroup_created_at';
    const UPDATED_AT = 'postgroup_updated_at';

    protected $fillable = [
        'postgroup_id',
        'postgroup_created_at',
        'postgroup_updated_at',
        'postgroup_created_by',
        'postgroup_updated_by',
        'postgroup_deleted_by',
        //vi
        'postgroup_name',
        'postgroup_description',
        'postgroup_slug',
        'postgroup_url',
        'postgroup_status',
        'postgroup_meta_title',
        'postgroup_meta_keywords',
        'postgroup_meta_description',
        'postgroup_is_delete',
        'postgroup_parent',
    ];

    const ALIAS = [
        'postgroup_id'                  => 'id',
        'postgroup_created_at'          => 'createdAt',
        'postgroup_updated_at'          => 'updatedAt',
        'postgroup_created_by'          => 'createdBy',
        'postgroup_updated_by'          => 'updatedBy',
        'postgroup_deleted_by'          => 'deletedBy',
        //vi
        'postgroup_name'                => 'name',
        'postgroup_description'         => 'description',
        'postgroup_status'              => 'status',
        'postgroup_slug'                => 'slug',
        'postgroup_url'                 => 'url',
        'postgroup_meta_title'          => 'metaTitle',
        'postgroup_meta_keywords'       => 'metaKeywords',
        'postgroup_meta_description'    => 'metaDescription',
        'postgroup_is_delete'           => 'isDelete',
        'postgroup_parent'              => 'parent',
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
     * @return hasMany
     */
     public function items()
     {
        return $this->hasMany(self::class, 'postgroup_parent');
     }

     /**
     * @return hasMany
     */
     public function childItems()
     {
        return $this->hasMany(self::class, 'postgroup_parent')->with('items');
     }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('postgroup_is_delete', 'no');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'postgroup_id')
            ->where(['3rd_type' => 'postgroup', 'image_value' => config('my.image.value.postgroup.avatar'), 'image_status' => 'activated']);
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
    public function scopeIsParent($query)
    {
        return $query->where('postgroup_parent', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotParent($query)
    {
        return $query->where('postgroup_parent', '<>', 0);
    }
}
