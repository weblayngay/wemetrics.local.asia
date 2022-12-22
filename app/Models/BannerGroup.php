<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BannerGroup extends BaseModel
{
    use HasFactory;
    protected $table    = BANNER_GROUP_TBL;
    protected $primaryKey = 'bannergroup_id';
    const CREATED_AT = 'bannergroup_created_at';
    const UPDATED_AT = 'bannergroup_updated_at';

    protected $fillable = [
        'bannergroup_id',
        'bannergroup_created_at',
        'bannergroup_update_at',
        'bannergroup_created_by',
        'bannergroup_updated_by',
        'bannergroup_deleted_by',

        //vi
        'bannergroup_name',
        'bannergroup_status',
        'bannergroup_description',
        'bannergroup_slug',
        'bannergroup_url',
        'bannergroup_is_delete',
        'bannergroup_parent'
    ];

    const ALIAS = [
        'bannergroup_id'               => 'id',
        'bannergroup_created_at'       => 'createdAt',
        'bannergroup_update_at'        => 'updatedAt',
        'bannergroup_created_by'       => 'createdBy',
        'bannergroup_updated_by'       => 'updatedBy',
        'bannergroup_deleted_by'       => 'deletedBy',
        'bannergroup_name'             => 'name',
        'bannergroup_status'           => 'status',
        'bannergroup_description'      => 'description',
        'bannergroup_slug'             => 'slug',
        'bannergroup_url'             => 'url',
        'bannergroup_is_delete'        => 'isDelete',
        'bannergroup_parent'           => 'parent',
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
        return $this->hasMany(self::class, 'bannergroup_parent');
     }

     /**
     * @return hasMany
     */
     public function childItems()
     {
        return $this->hasMany(self::class, 'bannergroup_parent')->with('items');
     }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('bannergroup_is_delete', 'no');
    }

    /**
     * @return HasMany
     */
    public function banners(): HasMany
    {
        return parent::HasMany('App\Models\Banner', 'banner_group', 'bannergroup_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('bannergroup_status', 'activated');
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsParent($query)
    {
        return $query->where('bannergroup_parent', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotParent($query)
    {
        return $query->where('bannergroup_parent', '<>', 0);
    }
}
