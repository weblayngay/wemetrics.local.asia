<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4Reseller extends BaseModel
{
    use HasFactory;

    protected $table = LT4_RESELLER;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kv_rid',
        'aff_rid',
        'name',
        'thumb',
        'address',
        'city_id',
        'dist_id',
        'hotline',
        'short_desc',
        'description',
        'created',
        'is_hot',
        'enable',
        'ordering',
        'meta_title',
        'meta_key',
        'meta_desc',
    ];

    const ALIAS = [
        'kv_rid'        => 'kvRid',
        'aff_rid'       => 'affRid',
        'name'          => 'name',
        'thumb'         => 'thumb',
        'address'       => 'address',
        'city_id'       => 'cityId',
        'dist_id'       => 'distId',
        'hotline'       => 'hotline',
        'short_desc'    => 'shortDesc',
        'description'   => 'description',
        'created'       => 'created',
        'is_hot'        => 'isHot',
        'enable'        => 'enable',
        'ordering'      => 'ordering',
        'meta_title'    => 'metaTitle',
        'meta_key'      => 'metaKey',
        'meta_desc'     => 'metaDesc',
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
        return $query->where('enable', '1');
    }                   
}
