<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsAffiliateResellers extends BaseModel
{
    use HasFactory;

    protected $table = TS_AFFILIATE_RESELLERS;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'address',
        'phone',
        'address',
        'prv_id',
        'gid',
        'registerdate',
        'lastvisitdate',
        'activation',
        'hpageid',
        'enable',
        'defaultresl',

    ];

    const ALIAS = [
        'gid'           => 'gid',
        'name'          => 'name',
        'username'      => 'username',
        'email'         => 'email',
        'password'      => 'password',
        'address'       => 'address',
        'phone'         => 'phone',
        'address'       => 'address',
        'prv_id'        => 'prv_id',
        'gid'           => 'gid',
        'registerdate'  => 'registerdate',
        'lastvisitdate' => 'lastvisitdate',
        'activation'    => 'activation',
        'hpageid'       => 'hpageid',
        'enable'        => 'enable',
        'defaultresl'   => 'defaultresl',

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
    static function query()
    {
        return parent::query();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsEnabled($query)
    {
        return $query
        ->where('enable', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotEnabled($query)
    {
        return $query
        ->where('enable', '0');
    }
}
