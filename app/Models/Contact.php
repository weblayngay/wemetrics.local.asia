<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends BaseModel
{
    use HasFactory;
    protected $table    = CONTACT_TBL;
    protected $primaryKey = 'contact_id';
    const CREATED_AT = 'contact_created_at';
    const UPDATED_AT = 'contact_updated_at';

    protected $fillable = [
        'contact_id',
        'contact_created_at',
        'contact_updated_at',
        'contact_created_by',
        'contact_updated_by',
        'contact_deleted_by',

        //vi
        'contact_name',
        'contact_email',
        'contact_status',
        'contact_subject',
        'contact_content',
        'contact_address',
        'contact_is_delete',
        'contact_phone_number',
        'contact_zalo_id',
        'contact_facebook_id',
    ];

    const ALIAS = [
        'contact_id'                => 'id',
        'contact_created_at'        => 'createdAt',
        'contact_updated_at'        => 'updatedAt',
        'contact_created_by'        => 'createdBy',
        'contact_updated_by'        => 'updatedBy',
        'contact_deleted_by'        => 'deletedBy',
        'contact_name'              => 'name',
        'contact_email'             => 'email',
        'contact_status'            => 'status',
        'contact_subject'           => 'subject',
        'contact_content'           => 'content',
        'contact_address'           => 'address',
        'contact_is_delete'         => 'isDelete',
        'contact_phone_number'      => 'phoneNumber',
        'contact_zalo_id'           => 'zaloId',
        'contact_facebook_id'       => 'facebookId',
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
        return $query->where('contact_is_delete', 'no');
    }
}
