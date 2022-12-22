<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ContactExtend extends BaseModel
{
    use HasFactory;
    protected $table    = CONTACT_EXTEND_TBL;
    protected $primaryKey = 'contactextend_id';
    const CREATED_AT = 'contactextend_created_at';
    const UPDATED_AT = 'contactextend_updated_at';

    protected $fillable = [
        'contactextend_id',
        'contactextend_created_at',
        'contactextend_updated_at',
        'contactextend_created_by',
        'contactextend_updated_by',
        'contactextend_deleted_by',
        'contactextend_is_delete',
        'contactextend_sorted',

        //vi
        'contactextend_name',
        'contactextend_gender',
        'contactextend_phone_number',
        'contactextend_email',
        'contactextend_status',
        'contactextend_address',
        'contactextend_map',
        'contactextend_zalo_id',
        'contactextend_facebook_id',
    ];

    const ALIAS = [
        'contactextend_id'          => 'id',
        'contactextend_created_at'  => 'createdAt',
        'contactextend_updated_at'  => 'updatedAt',
        'contactextend_created_by'  => 'createdBy',
        'contactextend_updated_by'  => 'updatedBy',
        'contactextend_deleted_by'  => 'deletedBy',
        'contactextend_is_delete'   => 'isDelete',
        'contactextend_sorted'      => 'sorted',
        'contactextend_name'        => 'name',
        'contactextend_phone_number'      => 'phoneNumber',
        'contactextend_email'       => 'email',
        'contactextend_status'      => 'status',
        'contactextend_address'     => 'address',
        'contactextend_map'         => 'map',
        'contactextend_zalo_id'     => 'zaloId',
        'contactextend_facebook_id' => 'facebookId',
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
        return $query->where('contactextend_is_delete', 'no');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'contactextend_id')
            ->where(['3rd_type' => 'contactextend', 'image_value' => config('my.image.value.contactextend.avatar'), 'image_status' => 'activated']);
    }
}
