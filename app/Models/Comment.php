<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends BaseModel
{
    use HasFactory;
    protected $table    = COMMENT_TBL;
    protected $primaryKey = 'comment_id';
    const CREATED_AT = 'comment_created_at';
    const UPDATED_AT = 'comment_updated_at';

    protected $fillable = [
        'comment_content',
        'comment_status',
        'comment_created_at',
        'comment_updated_at',
        'comment_updated_by',
        'comment_parent',
        'comment_level',
        'comment_rating',
        'comment_3rd_id',
        'comment_type',
        'user_id',
    ];

    const ALIAS = [
        'comment_content'           => 'content',
        'comment_status'            => 'status',
        'comment_created_at'        => 'createdAt',
        'comment_updated_at'        => 'updatedAt',
        'comment_updated_by'        => 'updatedBy',
        'comment_parent'            => 'parent',
        'comment_level'             => 'level',
        'comment_rating'            => 'rating',
        'comment_3rd_id'            => '3rdId',
        'comment_type'              => 'type',
        'user_id'                   => 'userId',
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
        return parent::query();
        
    }

     /**
     * @return hasMany
     */
     public function items()
     {
        return $this->hasMany(self::class, 'comment_parent');
     }

     /**
     * @return hasMany
     */
     public function childItems()
     {
        return $this->hasMany(self::class, 'comment_parent')->with('items');
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
