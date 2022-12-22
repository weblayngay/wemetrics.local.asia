<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Advert extends BaseModel
{
    use HasFactory;
    protected $table    = ADVERT_TBL;
    protected $primaryKey = 'advert_id';
    const CREATED_AT = 'advert_created_at';
    const UPDATED_AT = 'advert_updated_at';

    protected $fillable = [
        'advert_id',
        'advert_created_at',
        'advert_updated_at',
        'advert_created_by',
        'advert_updated_by',
        'advert_deleted_by',

        //vi
        'advert_name',
        'advert_slug',
        'advert_url',
        'advert_group',
        'advert_status',
        'advert_description',
        'advert_view',
        'advert_is_delete',
        'advert_sorted',

        //meta
        'advert_title',
        'advert_subtitle',
        'advert_use_name',
        'advert_use_email',
        'advert_use_phone_number',
        'advert_use_address',
        'advert_use_age',

        //email
        'advert_email_send',
        'advert_email_subject',
        'advert_email_content',

    ];

    const ALIAS = [
        'advert_id'               => 'id',
        'advert_created_at'       => 'createdAt',
        'advert_updated_at'       => 'updateAt',
        'advert_created_by'       => 'createdBy',
        'advert_updated_by'       => 'updatedBy',
        'advert_deleted_by'       => 'deletedBy',
        'advert_name'             => 'name',
        'advert_slug'             => 'slug',
        'advert_url'              => 'url',
        'advert_group'            => 'group',
        'advert_status'           => 'status',
        'advert_description'      => 'description',
        'advert_view'             => 'view',
        'advert_is_delete'        => 'delete',
        'advert_sorted'           => 'sorted',
        'advert_title'            => 'title',
        'advert_subtitle'         => 'subTitle',
        'advert_use_name'         => 'useName',
        'advert_use_email'        => 'useEmail',
        'advert_use_phone_number' => 'usePhoneNumber',
        'advert_use_address'      => 'useAddress',
        'advert_use_age'          => 'useAge',
        'advert_email_send'       => 'emailSend',
        'advert_email_subject'    => 'emailSubject',
        'advert_email_content'    => 'emailContent',
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
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('advert_is_delete', 'no');
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
     * @param int $advertGroupId
     * @return mixed
     */
    public function findByAdvertGroupId(int $advertGroupId)
    {
        return parent::query()->where(['advert_group' => $advertGroupId])->isActivated()->get();
    }

    /**
     * @param string $advertgroupCode
     * @param int $limit
     * @return mixed
     */
    public function findByAdvertGroupCode(string $advertCode, int $limit = 10)
    {
        return parent::query()->join(BANNER_GROUP_TBL, BANNER_GROUP_TBL . '.adgroup_id', BANNER_TBL . '.advert_group')
            ->where(['adgroup_code' => $bannerCode])->isActivated()->limit($limit)->orderBy('advert_sorted', 'asc')->get();
    }

    /**
     * @return HasOne
     */
    public function group(): HasOne
    {
        return $this->HasOne('App\Models\AdvertGroup', 'adgroup_id', 'advert_group');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'advert_id')
            ->where(['3rd_type' => 'advert', 'image_value' => config('my.image.value.advert.avatar'), 'image_status' => 'activated']);
    }
}
