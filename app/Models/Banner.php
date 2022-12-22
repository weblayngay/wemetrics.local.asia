<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Banner extends BaseModel
{
    use HasFactory;

    protected $table = BANNER_TBL;
    protected $primaryKey = 'banner_id';
    const CREATED_AT = 'banner_created_at';
    const UPDATED_AT = 'banner_updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banner_name',
        'banner_slug',
        'banner_url',
        'banner_description',
        'banner_status',
        'banner_is_delete',
        'banner_group',
        'banner_sorted',
        'banner_created_at',
        'banner_updated_at',
        'banner_created_by',
        'banner_updated_by',
        'banner_deleted_by'
    ];

    const ALIAS = [
        'banner_id'               => 'id',
        'banner_created_at'       => 'createdAt',
        'banner_updated_at'       => 'updateAt',
        'banner_name'             => 'name',
        'banner_slug'             => 'slug',
        'banner_url'              => 'url',
        'banner_description'      => 'description',
        'banner_status'           => 'status',
        'banner_is_delete'        => 'delete',
        'banner_group'            => 'group',
        'banner_sorted'           => 'sorted',
        'banner_created_by'       => 'createdBy',
        'banner_updated_by'       => 'updatedBy',
        'banner_deleted_by'       => 'deletedBy',
    ];

    /**
     * @return Builder
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
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('banner_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('banner_status', 'activated');
    }

    /**
     * @param int $bannerGroupId
     * @return mixed
     */
    public function findByBannerGroupId(int $bannerGroupId)
    {
        return parent::query()->where(['banner_group' => $bannerGroupId])->isActivated()->get();
    }

    /**
     * @param string $bannerGroupCode
     * @param int $limit
     * @return mixed
     */
    public function findByBannerGroupCode(string $bannerGroupCode, int $limit = 10)
    {
        return parent::query()->join(BANNER_GROUP_TBL, BANNER_GROUP_TBL . '.bannergroup_id', BANNER_TBL . '.banner_group')
            ->where(['bannergroup_code' => $bannerGroupCode])->isActivated()->limit($limit)->orderBy('banner_sorted', 'asc')->get();
    }

    /**
     * @return hasOne
     */
    public function group(): HasOne
    {
        return $this->hasOne('App\Models\BannerGroup', 'bannergroup_id', 'banner_group');
    }

    /**
     * @return BelongsTo
     */
    public function groups(): BelongsTo
    {
        return $this->belongsTo('App\Models\BannerGroup', 'bannergroup_id', 'banner_group');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'banner_id')
            ->where(['3rd_type' => 'banner', 'image_value' => config('my.image.value.banner.avatar'), 'image_status' => 'activated']);
    }


    /**
     * Banner dùng chung cho các trang ngoại trừ homepage (frontend)
     * @return Builder|Model|object|null
     */
    public function getBannerAllPage()
    {
        return self::query()->where('banner_group', 5)->orderBy('banner_id', 'desc')->first();
    }
}
