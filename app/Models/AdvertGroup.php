<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class AdvertGroup extends BaseModel
{
    use HasFactory;
    protected $table    = ADVERT_GROUP_TBL;
    protected $primaryKey = 'adgroup_id';
    const CREATED_AT = 'adgroup_created_at';
    const UPDATED_AT = 'adgroup_updated_at';

    protected $fillable = [
        'adgroup_id',
        'adgroup_created_at',
        'adgroup_update_at',
        'adgroup_created_by',
        'adgroup_updated_by',
        'adgroup_deleted_by',

        //vi
        'adgroup_name',
        'adgroup_status',
        'adgroup_description',
        'adgroup_slug',
        'adgroup_url',
        'adgroup_is_delete',
        'adgroup_parent',
    ];

    const ALIAS = [
        'adgroup_id'               => 'id',
        'adgroup_created_at'       => 'createdAt',
        'adgroup_update_at'        => 'updatedAt',
        'adgroup_created_by'       => 'createdBy',
        'adgroup_updated_by'       => 'updatedBy',
        'adgroup_deleted_by'       => 'deletedBy',
        'adgroup_name'             => 'name',
        'adgroup_status'           => 'status',
        'adgroup_description'      => 'description',
        'adgroup_slug'             => 'slug',
        'adgroup_url'              => 'url',
        'adgroup_is_delete'        => 'isDelete',
        'adgroup_parent'           => 'parent',
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
        return $this->hasMany(self::class, 'adgroup_parent');
     }

     /**
     * @return hasMany
     */
     public function childItems()
     {
        return $this->hasMany(self::class, 'adgroup_parent')->with('items');
     }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('adgroup_is_delete', 'no');
    }

    /**
     * @return HasMany
     */
    public function adverts(): HasMany
    {
        return parent::HasMany('App\Models\Adverd', 'adgroup_id', 'adgroup_id');
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
        return $query->where('adgroup_parent', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotParent($query)
    {
        return $query->where('adgroup_parent', '<>', 0);
    }
}
