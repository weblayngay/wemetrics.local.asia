<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactConfig extends BaseModel
{
    use HasFactory;
    protected $table    = CONTACT_CONFIG_TBL;
    protected $primaryKey = 'contactconfig_id';
    const CREATED_AT = 'contactconfig_created_at';
    const UPDATED_AT = 'contactconfig_updated_at';

    protected $fillable = [
        'contactconfig_id',
        'contactconfig_created_at',
        'contactconfig_updated_at',
        'contactconfig_created_by',
        'contactconfig_updated_by',
        'contactconfig_deleted_by',
        'contactconfig_is_delete',

        //vi
        'contactconfig_name',
        'contactconfig_phone_numbers',
        'contactconfig_emails',
        'contactconfig_status',
        'contactconfig_subject',
        'contactconfig_content',
        'contactconfig_address',
        'contactconfig_map',
        'contactconfig_zalo_id',
        'contactconfig_facebook_id',
    ];

    const ALIAS = [
        'contactconfig_id'          => 'id',
        'contactconfig_created_at'  => 'createdAt',
        'contactconfig_updated_at'  => 'updatedAt',
        'contactconfig_created_by'  => 'createdBy',
        'contactconfig_updated_by'  => 'updatedBy',
        'contactconfig_deleted_by'  => 'deletedBy',
        'contactconfig_is_delete'   => 'isDelete',
        'contactconfig_name'        => 'name',
        'contactconfig_phone_numbers'      => 'phoneNumbers',
        'contactconfig_emails'      => 'emails',
        'contactconfig_status'      => 'status',
        'contactconfig_subject'     => 'subject',
        'contactconfig_content'     => 'content',
        'contactconfig_address'     => 'address',
        'contactconfig_map'         => 'map',
        'contactconfig_zalo_id'     => 'zaloId',
        'contactconfig_facebook_id' => 'facebookId',
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
        return $query->where('contactconfig_is_delete', 'no');
    }
}
